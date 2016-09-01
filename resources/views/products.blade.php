<!DOCTYPE html>
<html lang="en" ng-app="pct">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Shop Item - Price compersion tool</title>
    <script src="../assets/js/jquery.js"></script>
    <link rel="stylesheet" href="../assets/css/kendo.common.min.css" />
    <link rel="stylesheet" href="../assets/css/kendo.custom.css" />
    <link rel="stylesheet" href="../assets/css/kendo.mobile.all.min.css" />
    <!-- Bootstrap Core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../assets/css/shop-item.css" rel="stylesheet">
    <!-- Bootstrap Core JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/kendo.all.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .loading {
                position:absolute;
                top:0;
                left:0;
                width:100%;
                height:100%;
                z-index:1000;
                background-color:grey;
                opacity: .8;
            }
            .ajax-loader {
                position: absolute;
                left: 50%;
                top: 50%;
                margin-left: -32px; /* -1 * image width / 2 */
                margin-top: -32px;  /* -1 * image height / 2 */
                display: block;
            }
            .detail table thead tr{
                background: #222222;
                color: #fff;
            }
            .detail{
                border: 2px solid #111;
                padding: 20px;
                overflow: auto;
            }
            .form-action{
                margin-top: 24px;
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">PCT</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="#/comparission">Comparision</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row">
                <h4>Filters</h4>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="">Enter Url</label>
                        <input type="text" class="form-control" id="term" placeholder="Enter Url to search">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="">Price Range</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="from_price" placeholder="Max">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="to_price" placeholder="Min">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                       <div class="form-group">
                        <label for="">Sale Rank</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="sale_max" placeholder="Max">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="sale_min" placeholder="Min">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                       <div class="form-group">
                        <label for="">Stock Type</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="checkbox" id="stock_in"> Stock In
                            </div>
                            <div class="col-sm-6">
                                <input type="checkbox" id="stock_out"> Stock Out
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-action">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
                <br>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="grid">
                    </div>
                </div>
            </div>
        </div>
        <script type="text/x-kendo-template" id="template">
            <div class="detail">
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Info</th>
                                <th>Amazone</th>
                                <th>Walmart</th>
                                <th>Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Thumbnail</td>
                                <td><img src="img/ajax-loader.gif" alt=""></td>
                                <td><img src="img/ajax-loader.gif" alt=""></td>
                                <td><img src="#=walmart.thumbnailImage#" alt=""></td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>$23.2</td>
                                <td>$23.2</td>
                                <td>#=walmart.salePrice#</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>name file</td>
                                <td>name file</td>
                                <td>#=walmart.name#</td>
                            </tr>
                            <tr>
                                <td>Stock</td>
                                <td>name file</td>
                                <td>name file</td>
                                <td>#=walmart.stock#</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Star Rating</th>
                                <th>Cust Review</th>
                                <th>Recently Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>4</td>
                                <td>#=walmart.customerRating#</td>
                                <td>15-2-2016</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Amazone Seller</th>
                                <th>New Offer</th>
                                <th>Used Offers</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Yes</td>
                                <td>152</td>
                                <td>15-2-2016</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Amazone Qty</th>
                                <th>New Qty</th>
                                <th>Used Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Yes</td>
                                <td>152</td>
                                <td>15-2-2016</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr />
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Keepa</th>
                                <th>Amazone</th>
                                <th>New</th>
                                <th>Used</th>
                                <th>Sale Rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lowest</td>
                                <td>11.5</td>
                                <td>4.79</td>
                                <td>8.79</td>
                                <td>32</td>
                            </tr><tr>
                            <td>Current</td>
                            <td>11.5</td>
                            <td>4.79</td>
                            <td>8.79</td>
                            <td>169</td>
                        </tr><tr>
                        <td>Highest</td>
                        <td>11.35</td>
                        <td>11.35</td>
                        <td>out of stock</td>
                        <td>4,829</td>
                    </tr><tr>
                    <td>Average</td>
                    <td>11.5</td>
                    <td>11.79</td>
                    <td>10.79</td>
                    <td>199</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</script>
<script>
    function list(url) {
        var priceFrom = $('#from_price').val();
        var priceTo = $('#to_price').val();
        var searchUrl = $('#term').val();
        var saleRank = $('#sale_rank').val();
        $("#grid").kendoGrid({
            dataSource: {
                transport: {
                    read: {
                        url:url,
                        type: "GET",
                        dataType: "json",
                        data: {
                            "from_price": priceFrom,
                            "to_price": priceTo,
                            "query":searchUrl,
                            "saleRank":saleRank
                        }
                    }

                },
                pageSize: 5,
                serverPaging: true,
                serverSorting: true
            },
            sortable: true,
            pageable: true,
            scrollable: false,
            resizable: true,
            filterable: true,
            columnMenu: true,
            groupable: true,
            detailTemplate: kendo.template($("#template").html()),
            detailInit: detailInit,
// dataBound: function() {
//     this.expandRow(this.tbody.find("tr.k-master-row").first());
// },
columns: [{
    field: "thumbnailImage",
    title: "Image",
    template:"<img src='#=thumbnailImage#'>"
},{
    field: "name",
    title: "Name",
},{
    field: "standardShipRate",
    title: "Ship Rate",
},{
    field: "price",
    title: "Sale Price"
},{
    field: "listPrice",
    title: "List Price"
},{
    field: "stock",
    title: "Stock"
},{
    field: "upc",
    title: "UPC"
}
,{
    field: "modelNumber ",
    title: "Modal",
},{
    field: "productUrl ",
    title: "Url",
    template:"<a href='#=productUrl#'>click</a>"
}]
});
        function detailInit(e) {
            var detailRow = e.detailRow;
            console.log(detailRow);
            var term = e.data.upc;
            if (term=="") {
                term = e.data.name;
            }
            detailRow.find(".tabstrip").kendoTabStrip({
                animation: {
                    open: { effects: "fadeIn" }
                }
            });
            detailRow.find(".detail").kendoGrid({
                dataSource: {
                    type: "json",
                    transport: {
                        read: "<?=url('api/get_product_detail')?>/"+term
                    },
                    serverPaging: true,
                    serverSorting: true,
                    serverFiltering: true,
                    pageSize: 7,
// filter: { field: "EmployeeID", operator: "eq", value: e.data.EmployeeID }
},
scrollable: false,
sortable: true,
pageable: true,
columns: [
{ field: "OrderID", title:"ID", width: "70px" },
{ field: "ShipCountry", title:"Ship Country", width: "110px" },
{ field: "ShipAddress", title:"Ship Address" },
{ field: "ShipName", title: "Ship Name", width: "300px" }
]
});
        }
    }
    jQuery(document).ready(function($) {
        list("<?=url('api/get_products')?>");
    });
    $('body').on('keyup', '#term,#from_price,#to_price,#sale_rank', function(event) {
        event.preventDefault();
        delay(function(){
            list("<?=url('api/get_products')?>");
        }, 500 );
    });
    var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();
</script>
</body>
</html>