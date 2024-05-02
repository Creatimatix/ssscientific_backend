@extends('admin.layouts.master')

@section('content')

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Cards -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalQuotes }}</h3>

                                <p>New Quotation</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
{{--                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $approvedQuotes }}</h3>

                                <p>Approved Quotation</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
{{--                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{  $otherQuotes }}</h3>

                                <p>Other Quotation</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
{{--                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{  $rejectedQuotes }}</h3>

                                <p>Rejected Quotation</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
{{--                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>--}}
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Charts -->
                <div class="row">
                    <div class="container-fluid d-flex">
                        <div class="col-sm-8 col-md-6">
                            <div class="card">
                                <div class="card-header" style="display:flex">
                                    <div class="row">
                                        <div style=" padding-right: 299px; ">Quotation chart</div>
                                        <div class="pull-right">
                                            <select class="form-control-sm" id="quoteYearFilter">
                                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ date('Y')- $i }}">{{ date('Y') - $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="height: 420px">
                                    <div id="quotationPieChartDiv">
                                        <span class='wait'>Please wait....</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Charts -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

@endsection

@section('pageScript')
    <style src="{{ asset('css/dashboard.css') }}"></style>
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    <script>
        var quotationChart=null;
        $(document).ready(function() {
            loadQuotationChart();
        });

        $(document).on("change",'#quoteYearFilter', function(){
            loadQuotationChart(true);
        });

        function loadQuotationChart(status=false){
            $('#quotationPieChartDiv').html("<span class='wait'>Please wait....</span>");
            var pieChartContent = document.getElementById('quotationPieChartDiv');
            pieChartContent.innerHTML = '&nbsp;';
            $('#quotationPieChartDiv').append('<canvas id="quotationPieChart"  width="299" height="200" style="display: block; width: 299px; height: 200px;"><canvas>');
            $.ajax({
                url: siteUrl+'/dashboard-quote-chart',
                method: 'GET',
                data: {"year":$('#quoteYearFilter').val()},
                success: function(response) {
                    var data = response.data;

                    var ctx = $("#quotationPieChart").get(0).getContext("2d");

                    if(quotationChart!=null){
                        quotationChart.destroy();
                    }

                    var quotationChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: Object.keys(data),
                            datasets: [{
                                data: Object.values(data),
                                backgroundColor: ["rgba(23,162,184)", "rgba(40,167,69)", "rgba(255,193,7)", "rgba(220,53,69)"]
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: 'Quotations'
                            }
                        }
                    });

                    if(status){
                        quotationChart.update();
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection
