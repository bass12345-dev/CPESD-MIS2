<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left"><?php echo $title ?></h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{url('/user/pmas/dashboard')}}">Home</a></li>
                    <li><a href=""><?php echo $title ?></a></li>
                </ul>
            </div>
        </div>
        <?php if(session('user_type') == 'user') : ?>
        <div class="col-sm-6 clearfix">
            <div class=" pull-right">
                    <a href="{{url('user/pmas/add')}}" id="add_transactions" class="btn sub-button mb-2 mt-2 mr-2" >Add PMAS Transaction</a>  
            </div>
        </div>
        <?php endif; ?>
    </div>