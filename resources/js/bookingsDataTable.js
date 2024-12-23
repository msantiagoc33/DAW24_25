let dataTable;
let dataTableIsInitialized = false;

const dataTableOptions = {
  lengthMenu: [5, 10, 15, 20, 25, 50, 100, "Todos"],
  scrollX: true,
  columnDefs: [
    {
      className: "centered",
      targets: [3, 4, 5, 6],
    },
    { orderable: false, targets: [6, 7] },
    { width: "5%", targets: [3, 6] },
    // { searchable: false, targets: [2] }, // No se puede buscar por la columna indicada
  ],
  pageLength: 5,
  destroy: true,
  language: {
    url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json",
  },
};

if (dataTableIsInitialized) {
  dataTable.destroy();
}

dataTable = $("#bookings-table").DataTable(dataTableOptions);

dataTableIsInitialized = true;
