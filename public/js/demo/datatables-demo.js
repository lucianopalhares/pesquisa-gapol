// Call the dataTables jQuery plugin
$(document).ready(function() {

  $('#dataTable').DataTable({
        "order": [[ 0, "asc" ]],
        "language": {
        "lengthMenu": "Mostrar _MENU_ items por pagina",
        "zeroRecords": "Nada encontrado",
        "info": "Mostrando pagina _PAGE_ of _PAGES_",
        "infoEmpty": "Sem datos disponiveis",
        "infoFiltered": "(filtrado de _MAX_ total items)",
        "search" : "Buscar",
        "paginate": {
          "previous": "Anterior",
          "next": "Próximo"
        }
    }
  });

});
