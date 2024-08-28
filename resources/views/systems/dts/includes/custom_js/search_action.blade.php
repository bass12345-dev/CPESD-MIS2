<script>
     $('form#search_form').on('submit', function(e) {
    e.preventDefault();
    var q = $('input[name=search]').val();
    $('.result-card').addClass('d-none')
    $('.result').html('');
    
    
    $.ajax({
      url: base_url + '/user/act/dts/search?q=' + q,
      method: 'GET',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      beforeSend : function(){
            loader();
      },
      success: function(data) {
        $('.result-card').removeClass('d-none');
        JsLoadingOverlay.hide();
        if (data.length > 0) {
          
          let arr = [];
          $('.card-title').text(data.length + ' Result/s');
          simpleTemplating(data);
          $('.pagination-container').pagination({
            dataSource: data,
            pageSize:50,
            showPageNumbers: true,
            showNavigator: true,
            showSizeChanger: true,
            callback: function(data, pagination) {
              var html = simpleTemplating(data);
              $('.data-container').html(html);
              highlightText(q);
            }
          });
          $('.pagination-container').removeClass('d-none');
         
        } else {
          $('.card-title').text('0 Result/s');
          $('.data-container').html('<div class="row d-flex justify-content-center text-danger" style="font-size: 20px;">Sorry! We can\'t find the document you\'re looking for</div>');
          $('.pagination-container').addClass('d-none');
        }
      },
      error: function() {
        alert('something Wrong');
        location.reload();
      }

    });

  });

  function simpleTemplating(data) {
    var html = '<ul class="list-group">';
    $.each(data, function(index, item) {
      
      html += '<li class="list-group-item">\
      <details class="details" open>\
          <summary ><a href="'+ base_url + '/{{session("user_type")}}/dts/view?tn=' + item.tracking_number+'">' + item.document_name + '</a></summary>\
          <p>'+item.document_description+'</p>\
          <b><span>#'+item.tracking_number+'</span></b>\
        </details>\
      </li>';
    });
    html += '</ul>';
    return html;
  }

  function highlightText(query){
    

    const searchValue = query.trim();
    const contentElement = document.querySelector('.data-container');

    
    if (searchValue !== '') {
         const content = contentElement.innerHTML;
         const highlightedContent = content.replace(
            new RegExp(searchValue, 'gi'),
            '<span class="highlight">$&</span>'
         );
         contentElement.innerHTML = highlightedContent;
        
        
         } else {
            contentElement.innerHTML = contentElement.textContent;
           
            
         }

  }

</script>
