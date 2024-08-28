<script>
     function load_total_pending_transactions() {
      $.ajax({
         type: "GET",
         url: base_url + '/user/act/pmas/count-pending-transactions',
         cache: false,
         dataType: 'text',
         success: function (data) {
            $('.count_pending').text(data);
         }
      })
   }
   $(document).ready(function () {
      load_total_pending_transactions();
   })
</script>