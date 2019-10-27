
 <footer class="text-center">
     &copy; Fingrtip And Team @ 2019
   </footer>
</div>


<script src="../bootstrap/popper.min.js"></script>
<script src="../bootstrap/js/main.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
<script>
function updateSizes(){
var sizeString = '';
for(var i =1; i<= 12; i++){
  if($('#size'+i).val()!=''){
    sizeString += $('#size'+i).val()+':'+$('#qty'+i).val()  + ',' + ' ';
  }
}
 sizeString = sizeString.replace(/,\s*$/, "");
$('#sizes').val(sizeString);
}


function get_child_options(selected){
  if(typeof selected === undefined){
    var selected ='';
  }
  var parentId = $('#parent').val();
  $.ajax({
  url:'/phpecommerce/admin/parsers/child_category.php',
  type:'POST',
  data : {parentId : parentId, selected:selected},
  success: function(data){
    $('#child').html(data);
  },
  error: function(){alert("Somethim went wrong with chil options.");},
  });
}
  $('select[name="parent"]').change(function(){get_child_options()});
</script>

</body>
</html>