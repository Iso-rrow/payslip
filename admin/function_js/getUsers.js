"use strict";

var dt;

var UserDatatableServerSide = (function () {
  var table;

  var initDatatable = function () {
    dt = $("#kt_datatable_example_2").DataTable({
      searchDelay: 500,
      processing: true,
      serverSide: true,
      stateSave: true,
      order: [[5, "desc"]],
      select: {
        style: "multi",
        selector: 'td:first-child input[type="checkbox"]',
        className: "row-selected",
      },
      ajax: {
        url: "/h_r_3/admin/function_php/getUsers.php",
        type: "POST",
        dataSrc: "data",
      },
      columns: [
        { data: "id" },
        { data: "employee_id" },
        { data: "name" },
        { data: "email" },
        { data: "role" },
        { data: "created_at" },
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
              </div>`;
          },
        },
        {
          targets: -1,
          orderable: false,
          className: "text-end",
          render: function (data, type, row) {
            return `
              <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click">
                Actions <span class="svg-icon fs-5 m-0"></span>
              </a>
              <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                <div class="menu-item px-3">
                  <a href="#" class="menu-link px-3" data-kt-user-table-filter="edit_row" data-id="${row.id}">Edit</a>
                </div>
                <div class="menu-item px-3">
                  <a href="#" class="menu-link px-3" data-kt-user-table-filter="delete_row" data-id="${row.id}">Delete</a>
                </div>
              </div>`;
          },
        },
      ],
    });

    table = dt.$;

    dt.on("draw", function () {
      toggleToolbars();
      initToggleToolbar();
      handleDeleteRows();
      handleEditRows();
      KTMenu.createInstances();
    });
  };

  var handleSearchDatatable = function () {
    const filterSearch = document.querySelector('[data-kt-employee-table-filter="search"]');
    if (filterSearch) {
      filterSearch.addEventListener("keyup", function (e) {
        dt.search(e.target.value).draw();
      });
    }
  };

  var handleDeleteRows = function () {
    document.querySelectorAll('[data-kt-user-table-filter="delete_row"]').forEach((btn) => {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        const id = this.getAttribute("data-id");
        Swal.fire({
          text: `Are you sure you want to delete user ID ${id}?`,
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
            fetch(`/h_r_3/admin/function_php/deleteUser.php?id=${id}`, {
              method: "POST",
            })
              .then((res) => res.json())
              .then((data) => {
                if (data.success) {
                  dt.draw();
                  Swal.fire("Deleted!", "User deleted successfully.", "success");
                } else {
                  Swal.fire("Error!", data.message || "Delete failed!", "error");
                }
              });
          }
        });
      });
    });
  };

  // ✅ Edit Handler
  var handleEditRows = function () {
    document.querySelectorAll('[data-kt-user-table-filter="edit_row"]').forEach((btn) => {
      btn.addEventListener("click", function (e) {
        e.preventDefault();
        const id = this.getAttribute("data-id");

        fetch(`/h_r_3/admin/function_php/editUsers.php?id=${id}`)
          .then((res) => res.json())
          .then((data) => {
            if (data.error) {
              Swal.fire("Error", data.error, "error");
              return;
            }

            document.querySelector("#edit_id").value = data.id || "";
            document.querySelector("#edit_employee_id").value = data.employee_id || "";
            document.querySelector("#edit_name").value = data.name || "";
            document.querySelector("#edit_email").value = data.email || "";
            document.querySelector("#edit_role").value = data.role || "";

            const modal = new bootstrap.Modal(document.getElementById("editUserModal"));
            modal.show();
          })
          .catch((err) => {
            console.error(err);
            Swal.fire("Error", "Failed to load user data.", "error");
          });
      });
    });
  };

  // ✅ Update Handler
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#editUserForm");
    if (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        fetch("/h_r_3/admin/function_php/updateUsers.php", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.success) {
              Swal.fire("Updated!", "User updated successfully.", "success");
              const modal = bootstrap.Modal.getInstance(document.getElementById("editUserModal"));
              modal.hide();
              dt.draw();
            } else {
              Swal.fire("Error", data.message || "Update failed.", "error");
            }
          })
          .catch((err) => {
            console.error(err);
            Swal.fire("Error", "Update request failed.", "error");
          });
      });
    }
  });

  var initToggleToolbar = function () {
    const container = document.querySelector("#kt_datatable_example_2");
    const checkboxes = container.querySelectorAll('[type="checkbox"]');
    const deleteSelected = document.querySelector('[data-kt-employee-table-select="delete_selected"]');

    checkboxes.forEach((c) => {
      c.addEventListener("click", function () {
        setTimeout(toggleToolbars, 50);
      });
    });

    if (deleteSelected) {
      deleteSelected.addEventListener("click", function () {
        Swal.fire({
          text: "Are you sure you want to delete selected users?",
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
            dt.rows(".row-selected").remove().draw();
            Swal.fire("Deleted!", "Selected users removed.", "success");
          }
        });
      });
    }
  };

  var toggleToolbars = function () {
    const container = document.querySelector("#kt_datatable_example_2");
    const toolbarBase = document.querySelector('[data-kt-employee-table-toolbar="base"]');
    const toolbarSelected = document.querySelector('[data-kt-employee-table-toolbar="selected"]');
    const selectedCount = document.querySelector('[data-kt-employee-table-select="selected_count"]');

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

  return {
    init: function () {
      initDatatable();
      handleSearchDatatable();
    },
  };
})();

document.addEventListener("DOMContentLoaded", function () {
  UserDatatableServerSide.init();
});
