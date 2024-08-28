<script>
   function count_total_rfa_pending() {
      $.ajax({
         type: "GET",
         url: base_url + '/user/act/rfa/count-pending-rfa',
         cache: false,
         dataType: 'text',
         success: function (data) {
            $('.count_pending_rfa').text(data);
         }
      })
   }
   $(document).ready(function () {

      count_total_rfa_pending();
   });

</script>