
        <div class="pcoded-wrapper">
            <div class="box-breadcrump">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item breadcrumb__item-firstChild">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Home</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Search</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" name="login_username" required="" placeholder="Username" id="hpq-search">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#hpq-search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                if(value.length < 1) { $('.card-block').remove(); return; }
                search_text = value;


                $.ajax({url:URL+"api/search", type:"POST", data:{Name: search_text, _token: '342ub54ty45bgt4544fd5t4g4'},
                    success:function(result){
                        if(result.length < 1) return;
                        if($('.card-block')[0]) $('.card-block').remove();
                        $('.card').append(result);
                    }
                });
            });
        });
    </script>