$('#DataStruk').DataTable({
    processing: true,
    lengthMenu: [5,10],
    autoWidth: false,
    responsive: true,
    ordering: false,
    serverSide: true,
    ajax: '/transaction/ajaxreprint',
    columns: [
        {data: 'id', name: 't.id'},
        {data: 'Nama', name: 'c.Nama'},
        {data: 'date', name: 'date', searchable: false},
        {data: 'action', name: 'action', searchable: false}
    ]
})
