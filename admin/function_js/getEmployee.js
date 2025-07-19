"use strict";
var dt;
// Employee Datatable with Server-Side Processing
var EmployeeDatatableServerSide = (function () {
  var table;

  // 1. Initialize DataTable
  var initDatatable = function () {
    dt = $("#kt_datatable_example_1").DataTable({
      searchDelay: 500,
      processing: true,
      serverSide: true,
      stateSave: true,
      order: [[5, "desc"]], // Sort by Hire Date (column 5)
      select: {
        style: "multi",
        selector: 'td:first-child input[type="checkbox"]',
        className: "row-selected",
      },
      ajax: {
        url: "/payslip/admin/function_php/getEmployee.php", // <--- CHANGE TO YOUR SERVER ENDPOINT
        type: "POST",
        dataSrc: "data",
      },
      columns: [
        { data: "employee_id" },
        { data: "auto_employee_id" },
        { data: "last_name" },
        { data: "first_name" },
        { data: "department" },
        { data: "position" },
        { data: "hire_date" },
        { data: null },
      ],
      columnDefs: [
        {
          targets: 0,
          orderable: false,
          render: function (data) {
            return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>
                        `;
          },
        },
        {
          targets: -1,
          orderable: false,
          className: "text-end",
          render: function (data, type, row) {
            return `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click">
                                Actions
                                <span class="svg-icon fs-5 m-0">
                                    <!-- SVG for dropdown icon -->
                                </span>
                            </a>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-employee-table-filter="view_row" data-id="${row.employee_id}">
                                        View
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-employee-table-filter="edit_row" data-id="${row.employee_id}">
                                        Edit
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-employee-table-filter="delete_row" data-id="${row.employee_id}">
                                        Delete
                                    </a>
                                </div>
                            </div>
                        `;
          },
        },
      ],
      createdRow: function (row, data, dataIndex) {
        // Add custom data attributes if needed for filtering, etc.
      },
    });

    table = dt.$;

    // Re-initialize event handlers on redraw
    dt.on("draw", function () {
      initToggleToolbar();
      toggleToolbars();
      handleDeleteRows();
      handleViewRows();
      handleEditRows();
      KTMenu.createInstances();
    });
  };

  // 2. Search Datatable
  var handleSearchDatatable = function () {
    const filterSearch = document.querySelector(
      '[data-kt-employee-table-filter="search"]'
    );
    if (filterSearch) {
      filterSearch.addEventListener("keyup", function (e) {
        dt.search(e.target.value).draw();
      });
    }
  };

  // 3. (Optional) Filter Button Placeholder
  var handleFilterButton = function () {
    const filterBtn = document.querySelector(
      '[data-bs-toggle="tooltip"][title="Coming Soon"]'
    );
    if (filterBtn) {
      filterBtn.addEventListener("click", function () {
        // Here you can show a modal or sidebar filter (customize as needed)
        alert("Advanced filters coming soon!");
      });
    }
  };

  // 4. Delete Employee
  var handleDeleteRows = function () {
    // Listen for delete clicks
    document
      .querySelectorAll('[data-kt-employee-table-filter="delete_row"]')
      .forEach((btn) => {
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          const id = this.getAttribute("data-id");
          const row = this.closest("tr");
          const empName =
            row.querySelectorAll("td")[2].innerText +
            " " +
            row.querySelectorAll("td")[3].innerText;

          Swal.fire({
            text: `Are you sure you want to delete ${empName}?`,
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "No, cancel",
            customClass: {
              confirmButton: "btn fw-bold btn-danger",
              cancelButton: "btn fw-bold btn-active-light-primary",
            },
          }).then(function (result) {
            if (result.value) {
              // Call backend to delete
              fetch(
                `/payslip/admin/function_php/deleteEmployee.php?employee_id=${id}`,
                {
                  method: "POST",
                }
              )
                .then((res) => res.json())
                .then((data) => {
                  if (data.success) {
                    dt.draw();
                    Swal.fire({
                      text: "Employee deleted successfully!",
                      icon: "success",
                      confirmButtonText: "OK",
                      customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                      },
                    });
                  } else {
                    Swal.fire({
                      text: data.message || "Delete failed!",
                      icon: "error",
                      confirmButtonText: "OK",
                      customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                      },
                    });
                  }
                });
            }
          });
        });
      });
  };

  // Helper function to format date into YYYY-MM-DD
  function formatDateForInput(dateStr) {
    const date = new Date(dateStr);
    if (!isNaN(date.getTime())) {
      const yyyy = date.getFullYear();
      const mm = String(date.getMonth() + 1).padStart(2, "0");
      const dd = String(date.getDate()).padStart(2, "0");
      return `${yyyy}-${mm}-${dd}`;
    }
    return "";
  }

  // 5. Edit Employee
  var handleEditRows = function () {
    document
      .querySelectorAll('[data-kt-employee-table-filter="edit_row"]')
      .forEach((btn) => {
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          const id = this.getAttribute("data-id");

          fetch(
            `/payslip/admin/function_php/editEmployee.php?employee_id=${id}`
          )
            .then((res) => {
              if (!res.ok) throw new Error("Network response was not ok");
              return res.json();
            })
            .then((data) => {
              // Preview individual document files
              const docFields = [
                "sss_file",
                "philhealth_file",
                "pagibig_file",
                "drugtest_file",
                "nbi_file",
                "medical_file",
              ];
              docFields.forEach((field) => {
                const previewEl = document.getElementById(
                  `edit_${field}_preview`
                );
                if (previewEl) {
                  if (data[field]) {
                    const fileName = data[field].split("/").pop();
                    previewEl.innerHTML = `<a href="${data[field]}" target="_blank">${fileName}</a>`;
                  } else {
                    previewEl.innerHTML = "<em>No file uploaded.</em>";
                  }
                }
              });
              console.log("Employee fetched:", data);

              if (data.error) {
                alert(data.error);
                return;
              }

              // Show image preview if available
              const imgElement = document.getElementById("edit_employee_img");
              if (imgElement) {
                let imgPath = data.img_name || "default.jpg";
                if (!imgPath.includes("/payslip/uploads/employees/")) {
                  imgPath = `/payslip/uploads/employees/${imgPath}`;
                }
                imgElement.src = imgPath;

                imgElement.onerror = function () {
                  this.onerror = null;
                  this.src = "/payslip/uploads/employees/default.jpg";
                };
              }
              const existingImageInput = document.querySelector(
                "#existing_image_name"
              );
              if (existingImageInput) {
                existingImageInput.value = data.img_name || "default.jpg";
              }

              // Attach image preview logic
              const imageInput = document.getElementById(
                "employee_image_input"
              );
              if (imageInput) {
                imageInput.value = "";
                imageInput.addEventListener("change", function (event) {
                  const file = event.target.files[0];
                  if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                      if (imgElement) {
                        imgElement.src = e.target.result;
                      }
                    };
                    reader.readAsDataURL(file);
                  }
                });
              }

              document.querySelector("#edit_employee_id").value =
                data.employee_id || "";
              document.querySelector("#edit_auto_employee_id").value =
                data.auto_employee_id || "";
              document.querySelector("#edit_first_name").value =
                data.first_name || "";
              document.querySelector("#edit_last_name").value =
                data.last_name || "";
              document.querySelector("#edit_email").value = data.email || "";
              document.querySelector("#edit_contact_number").value =
                data.contact_number || "";
              document.querySelector("#edit_department").value =
                data.department || "";
              document.querySelector("#edit_position").value =
                data.position || "";
              document.querySelector("#edit_hire_date").value =
                formatDateForInput(data.hire_date);
              document.querySelector("#edit_scheduled_time_in").value =
                data.scheduled_time_in || "";
              document.querySelector("#edit_scheduled_time_out").value =
                data.scheduled_time_out || "";
              document.querySelector("#edit_sss_number").value =
                data.sss_number || "";
              document.querySelector("#edit_philhealth_number").value =
                data.philhealth_number || "";
              document.querySelector("#edit_pagibig_number").value =
                data.pagibig_number || "";
              document.querySelector("#edit_tin_number").value =
                data.tin_number || "";
              document.querySelector("#edit_salary_rate").value =
                data.salary_rate || "";
              document.querySelector("#edit_payment_method").value =
                data.payment_method || "";
              document.querySelector("#edit_address").value =
                data.address || "";
              document.querySelector("#edit_emergency_name").value =
                data.emergency_name || "";
              document.querySelector("#edit_emergency_phone").value =
                data.emergency_phone || "";
              document.querySelector("#edit_civil_status").value =
                data.civil_status || "";
              document.querySelector("#edit_sex").value = data.sex || "";
              document.querySelector("#edit_citizenship").value =
                data.citizenship || "";
              document.querySelector("#edit_height").value = data.height || "";
              document.querySelector("#edit_weight").value = data.weight || "";
              document.querySelector("#edit_religion").value =
                data.religion || "";

              const deptSelect = document.querySelector("#edit_department");
              if (deptSelect && data.department_id) {
                deptSelect.value = data.department_id;
              }

              if (data.department_id) {
                fetch("/payslip/admin/function_php/fetch_roles.php", {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                  },
                  body: `department_id=${data.department_id}`,
                })
                  .then((res) => res.text())
                  .then((html) => {
                    const roleSelect = document.querySelector("#edit_position");
                    roleSelect.innerHTML = html;

                    const roleIdStr = String(data.role_id);

                    setTimeout(() => {
                      const optionToSelect = roleSelect.querySelector(
                        `option[value="${roleIdStr}"]`
                      );
                      if (optionToSelect) {
                        roleSelect.value = roleIdStr;
                      } else {
                        console.warn(
                          `Role ID ${roleIdStr} not found in options.`
                        );
                      }
                    }, 50);
                  });
              }

              const docPreviewContainer = document.querySelector(
                "#edit_documents_preview"
              );
              if (docPreviewContainer) {
                if (data.documents) {
                  const fileLinks = data.documents
                    .split(",")
                    .map((path) => {
                      const fileName = path.split("/").pop();
                      return `<a href="${path}" target="_blank">${fileName}</a>`;
                    })
                    .join("<br>");
                  docPreviewContainer.innerHTML = fileLinks;
                } else {
                  docPreviewContainer.innerHTML =
                    "<em>No documents uploaded.</em>";
                }
              }

              const editModal = new bootstrap.Modal(
                document.getElementById("editEmployeeModal")
              );
              editModal.show();
            })
            .catch((error) => {
              console.error("Fetch error:", error);
              alert("Failed to fetch employee data.");
            });
        });
      });
  };

  // 6. View Employee
  var handleViewRows = function () {
    document
      .querySelectorAll('[data-kt-employee-table-filter="view_row"]')
      .forEach((btn) => {
        btn.addEventListener("click", function (e) {
          e.preventDefault();

          const employeeId = this.getAttribute("data-id");

          fetch(
            `/payslip/admin/function_php/getEmployeeInfo.php?id=${employeeId}`
          )
            .then((response) => response.json())
            .then((data) => {
              if (!data.success) {
                alert("Could not load employee data.");
                return;
              }

              const emp = data.employee;

              // --- IMAGE ---
              const imgElement = document.getElementById("view_employee_img");
              if (imgElement) {
                let imgPath = "/payslip/uploads/employees/default.jpg";
                if (emp.img_name && emp.img_name.trim() !== "") {
                  imgPath = emp.img_name.includes("/uploads/employees/")
                    ? emp.img_name
                    : `/payslip/uploads/employees/${emp.img_name}`;
                }
                imgElement.src = imgPath;
                imgElement.onerror = function () {
                  this.onerror = null;
                  this.src = "/payslip/uploads/employees/default.jpg";
                };
              }

              // --- FIELD SETTERS ---
              const fields = [
                "auto_employee_id",
                "first_name",
                "last_name",
                "email",
                "contact_number",
                "civil_status",
                "sex",
                "citizenship",
                "height",
                "weight",
                "religion",
                "department",
                "position",
                "hire_date",
                "scheduled_time_in",
                "scheduled_time_out",
                "sss_number",
                "philhealth_number",
                "pagibig_number",
                "tin_number",
                "salary_rate",
                "payment_method",
                "address",
                "emergency_name",
                "emergency_phone",
              ];

              fields.forEach((id) => {
                const el = document.getElementById(`view_${id}`);
                if (el) el.value = emp[id] || "";
              });

              const docFields = [
                "sss_file",
                "philhealth_file",
                "pagibig_file",
                "drugtest_file",
                "nbi_file",
                "medical_file",
              ];
              docFields.forEach((field) => {
                const previewEl = document.getElementById(
                  `view_${field}_preview`
                );
                if (previewEl) {
                  if (emp[field]) {
                    const fileName = emp[field].split("/").pop();
                    previewEl.innerHTML = `<a href="${emp[field]}" target="_blank">${fileName}</a>`;
                  } else {
                    previewEl.innerHTML = "<em>No file uploaded.</em>";
                  }
                }
              });

              const docPreview = document.getElementById(
                "view_documents_preview"
              );
              if (docPreview) {
                docPreview.innerHTML = "";
                if (emp.documents) {
                  emp.documents.split(",").forEach((file) => {
                    const link = document.createElement("a");
                    link.href = file;
                    link.textContent = file.split("/").pop();
                    link.target = "_blank";
                    link.classList.add("d-block");
                    docPreview.appendChild(link);
                  });
                } else {
                  docPreview.innerHTML = "<em>No documents uploaded.</em>";
                }
              }

              // Show modal
              const modal = new bootstrap.Modal(
                document.getElementById("viewEmployeeModal")
              );
              modal.show();
            })
            .catch((err) => {
              console.error(err);
              alert("Error retrieving employee info.");
            });
        });
      });
  };

  ////////////////////update function//////////////////////
  /////////////////////////////////////////////////////////

  document
    .querySelector("#editEmployeeForm")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch("/payslip/admin/function_php/updateEmployee.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            $("#editEmployeeModal").modal("hide");
            Swal.fire({
              text: "Employee updated successfully!",
              icon: "success",
              confirmButtonText: "OK",
              customClass: {
                confirmButton: "btn btn-primary",
              },
            });
            $("#kt_datatable_example_1").DataTable().ajax.reload();
          } else {
            Swal.fire({
              text: data.message || "Update failed!",
              icon: "error",
              confirmButtonText: "OK",
              customClass: {
                confirmButton: "btn btn-primary",
              },
            });
          }
        });
    });

  // 5. Toggle Toolbar on Row Selection
  var initToggleToolbar = function () {
    const container = document.querySelector("#kt_datatable_example_1");
    const checkboxes = container.querySelectorAll('[type="checkbox"]');
    const deleteSelected = document.querySelector(
      '[data-kt-employee-table-select="delete_selected"]'
    );

    checkboxes.forEach((c) => {
      c.addEventListener("click", function () {
        setTimeout(toggleToolbars, 50);
      });
    });

    if (deleteSelected) {
      deleteSelected.addEventListener("click", function () {
        Swal.fire({
          text: "Are you sure you want to delete selected employees?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, delete!",
          cancelButtonText: "No, cancel",
          customClass: {
            confirmButton: "btn fw-bold btn-danger",
            cancelButton: "btn fw-bold btn-active-light-primary",
          },
        }).then(function (result) {
          if (result.value) {
            // You can implement bulk delete here
            dt.rows(".row-selected").remove().draw(); // UI only, replace with AJAX for real delete
            Swal.fire({
              text: "Selected employees deleted.",
              icon: "success",
              confirmButtonText: "OK",
              customClass: {
                confirmButton: "btn fw-bold btn-primary",
              },
            });
          }
        });
      });
    }
  };

  var toggleToolbars = function () {
    const container = document.querySelector("#kt_datatable_example_1");
    const toolbarBase = document.querySelector(
      '[data-kt-employee-table-toolbar="base"]'
    );
    const toolbarSelected = document.querySelector(
      '[data-kt-employee-table-toolbar="selected"]'
    );
    const selectedCount = document.querySelector(
      '[data-kt-employee-table-select="selected_count"]'
    );

    const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');
    let checkedState = false;
    let count = 0;

    allCheckboxes.forEach((c) => {
      if (c.checked) {
        checkedState = true;
        count++;
      }
    });

    if (checkedState) {
      selectedCount.innerHTML = count;
      toolbarBase.classList.add("d-none");
      toolbarSelected.classList.remove("d-none");
    } else {
      toolbarBase.classList.remove("d-none");
      toolbarSelected.classList.add("d-none");
    }
  };

  // Public methods
  return {
    init: function () {
      initDatatable();
      handleSearchDatatable();
      handleFilterButton();
      initToggleToolbar();
      handleViewRows();
      handleDeleteRows();
    },
  };
})();

// On document ready (use KTUtil or jQuery ready)
document.addEventListener("DOMContentLoaded", function () {
  EmployeeDatatableServerSide.init();
});

// for roles for edit

// document
//   .querySelector("#edit_department")
//   .addEventListener("change", function () {
//     const departmentId = this.value;

//     fetch("/payslip/admin/function_php/fetch_roles.php", {
//       method: "POST",
//       headers: { "Content-Type": "application/x-www-form-urlencoded" },
//       body: `department_id=${departmentId}`,
//     })
//       .then((res) => res.text())
//       .then((html) => {
//         const roleSelect = document.querySelector("#edit_position");
//         roleSelect.innerHTML = html;
//       });
//   });
