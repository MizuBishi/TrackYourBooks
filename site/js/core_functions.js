
function getSeconds() {
  return Math.round(new Date().getTime() / 1000);
}

function addZeros(value) {
  if (value < 10) {
    return '0'+ value;
  }
  return value;
}

function formatSeconds(delta) {
  var seconds = addZeros(delta % 60);
  var minutes = addZeros(Math.floor(delta/60) % 60);
  var hours   = addZeros(Math.floor(delta/3600));
  return hours + ':'+ minutes + ':' + seconds;
}

function filterTable(filter) {
  $('table tr').hide();
  $('.tblHeader').show();
  $('table tr td').each(function() {
    if ($(this).text().toLowerCase().indexOf(filter.toLowerCase()) !== -1) {
      $(this).parent().show();
    }
  })
}
