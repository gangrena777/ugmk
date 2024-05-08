$(document).ready(function() {
        
   

  $('.delete_photo,.delete_doc').on('click', function(e){
         e.preventDefault();
         var isTrue  = confirm('удалить данные?');
         if(isTrue == true)
         {

         var href = $(this).attr('href');
          $(this).parent('div').remove();
          $.get(href);   

          }
        
    });

  /////validate  form  report  ///////////
  // $('#fot_report_form').on('submit', function (e) {

  //    e.preventDefault();
    
  //    if( $('input[name="date_from"]').val() == '' ||  $('input[name="date_to"]').val() == '' ){


  //       alert(" Ошибка!!!ВВедите период выборки");

  //    }else{
  //       // var from = $('input[name="date_from"]').val().replace(/[^+\d]/g, '');
  //       // var to = $('input[name="date_to"]').val().replace(/[^+\d]/g, '');



  //       // $.get(   $(this).attr('action'), { date_from: from, date_to:to} );
         
  //               e.preventDefault(false);


  //    }
    
      


  // });




});


// //work


// var exportToExcel = (function() {
//   var uri = 'data:application/vnd.ms-excel;base64,'
//     , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
//     , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
//     , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
//   return function(table, name) {
//     if (!table.nodeType) table = document.getElementById('Fot_table')
//     var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
//     window.location.href = uri + base64(format(template, ctx))
//   }
// })()


function exportToExcel(tableId){
  let tableData = document.getElementById(tableId).outerHTML;
  tableData = tableData.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
    tableData = tableData.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params


  let a = document.createElement('a');
  a.href = `data:application/vnd.ms-excel, ${encodeURIComponent(tableData)}`
  a.download = 'downloaded_file_' + getRandomNumbers() + '.xls'
  a.click()
}
function getRandomNumbers() {
  let dateObj = new Date()
  let dateTime = `${dateObj.getHours()}${dateObj.getMinutes()}${dateObj.getSeconds()}`

  return `${dateTime}${Math.floor((Math.random().toFixed(2)*100))}`
}


         
    
    
