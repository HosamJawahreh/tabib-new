@extends('layouts.admin')

@section('content')
<div class="content-area">
    @include('alerts.form-success')

    @if($activation_notify != "")
    <div class="alert alert-danger validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <h3 class="text-center">{!! clean($activation_notify, array('Attr.EnableID' => true)) !!}</h3>

    </div>
    @endif

    @if(Session::has('cache'))

    <div class="alert alert-success validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <h3 class="text-center">{{ Session::get("cache") }}</h3>
    </div>

    @endif

    <!-- Compact Statistics Row -->
    <div class="row row-cards-one mb-4">
        <div class="col-md-4 col-lg-4 col-xl-4">
            <div class="mycard bg1">
                <div class="left">
                    <h5 class="title">{{ __('Orders') }}</h5>
                    <span class="number">{{ App\Models\Order::count() }}</span>
                    <a href="{{ route('admin-orders-all') }}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-xl-4">
            <div class="mycard bg4">
                <div class="left">
                    <h5 class="title">{{ __('Products') }}</h5>
                    <span class="number">{{count($products)}}</span>
                    <a href="{{route('admin-prod-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-cart-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 col-xl-4">
            <div class="mycard bg5">
                <div class="left">
                    <h5 class="title">{{ __('Customers') }}</h5>
                    <span class="number">{{count($users)}}</span>
                    <a href="{{route('admin-user-index')}}" class="link">{{ __('View All') }}</a>
                </div>
                <div class="right d-flex align-self-center">
                    <div class="icon">
                        <i class="icofont-users-alt-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Chart Section -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm" style="border: none; border-radius: 12px;">
                <div class="card-header" style="background: #fff; border-bottom: 2px solid #f0f0f0; padding: 20px; border-radius: 12px 12px 0 0;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0" style="font-weight: 700; color: #2d3748; font-size: 18px;">
                            <i class="fas fa-chart-line" style="color: #667eea; margin-right: 8px;"></i>
                            {{ __('Revenue & Orders Analytics') }}
                        </h5>
                        <div class="btn-group mt-2 mt-md-0" role="group" id="chart-filters">
                            <button type="button" class="btn btn-sm filter-btn active" data-filter="today">
                                <i class="fas fa-calendar-day"></i> {{ __('Today') }}
                            </button>
                            <button type="button" class="btn btn-sm filter-btn" data-filter="week">
                                <i class="fas fa-calendar-week"></i> {{ __('This Week') }}
                            </button>
                            <button type="button" class="btn btn-sm filter-btn" data-filter="30">
                                <i class="fas fa-calendar-days"></i> {{ __('Last 30 Days') }}
                            </button>
                            <button type="button" class="btn btn-sm filter-btn" data-filter="monthly">
                                <i class="fas fa-calendar-alt"></i> {{ __('Monthly') }}
                            </button>
                            <button type="button" class="btn btn-sm filter-btn" data-filter="yearly">
                                <i class="fas fa-calendar"></i> {{ __('Yearly') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 30px;">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="analytics-stat-box" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3); transition: transform 0.3s ease;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-white mb-2" style="opacity: 0.9; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">{{ __('Total Revenue') }}</h6>
                                        <h2 class="text-white mb-0" id="totalRevenue" style="font-weight: 700; font-size: 32px;">
                                            @php
                                                $todayRevenueStat = App\Models\Order::where('status', 'completed')
                                                    ->whereDate('created_at', Carbon\Carbon::today())
                                                    ->sum('pay_amount');
                                            @endphp
                                            {{ \PriceHelper::showAdminCurrencyPrice($todayRevenueStat) }}
                                        </h2>
                                    </div>
                                    <div class="icon-wrapper" style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 12px;">
                                        <i class="fas fa-dollar-sign" style="font-size: 28px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="analytics-stat-box" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 16px rgba(245, 87, 108, 0.3); transition: transform 0.3s ease;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="text-white mb-2" style="opacity: 0.9; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">{{ __('Total Orders') }}</h6>
                                        <h2 class="text-white mb-0" id="totalOrders" style="font-weight: 700; font-size: 32px;">
                                            @php
                                                $todayOrdersStat = App\Models\Order::whereDate('created_at', Carbon\Carbon::today())->count();
                                            @endphp
                                            {{ $todayOrdersStat }}
                                        </h2>
                                    </div>
                                    <div class="icon-wrapper" style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 12px;">
                                        <i class="fas fa-shopping-cart" style="font-size: 28px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; height: 400px; background: #fafbfc; padding: 20px; border-radius: 12px;">
                        <canvas id="analyticsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cards-one">
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ App\Models\User::where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->count()  }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('New Customers') }}</h6>
                    <p class="text">{{ __('Last 30 Days') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ App\Models\User::count() }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Customers') }}</h6>
                    <p class="text">{{ __('All Time') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>{{ App\Models\Order::where('status','=','completed')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->count()  }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Sales') }}</h6>
                    <p class="text">{{ __('Last 30 days') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Order::where('status','=','completed')->get()->count() }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Sales') }}</h6>
                    <p class="text">{{ __('All Time') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cards-one">

        <div class="col-md-12 col-lg-6 col-sm-12 col-xl-6">
            <div class="card">
                <h5 class="card-header">{{ __('Recent Order(s)') }}</h5>
                <div class="card-body">

                <div class="table-responsive  dashboard-home-table">
                                    <table id="poproducts" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>

                                    <th>{{ __('Order Number') }}</th>
                                    <th>{{ __('Order Date') }}</th>
                                </tr>
                                @foreach($rorders as $data)
                                <tr>
                                    <td>{{ $data->order_number }}</td>
                                    <td>{{ date('Y-m-d',strtotime($data->created_at)) }}</td>
                                    <td>
                                        <div class="action-list"><a href="{{ route('admin-order-show',$data->id) }}"><i
                                                    class="fas fa-eye"></i> {{ __('Details') }}</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </thead>
                        </table>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-12 col-lg-6 col-sm-12 col-xl-6">
                <div class="card">
                        <h5 class="card-header">{{ __('Recent Customer(s)') }}</h5>
                        <div class="card-body">

                             <div class="table-responsive  dashboard-home-table">
                                    <table id="poproducts" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Customer Email') }}</th>
                                            <th>{{ __('Joined') }}</th>
                                        </tr>
                                        @foreach($rusers as $data)
                                        <tr>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->created_at }}</td>
                                            <td>
                                                <div class="action-list"><a href="{{ route('admin-user-show',$data->id) }}"><i
                                                            class="fas fa-eye"></i> {{ __('Details') }}</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>
        </div>
    </div>

    <div class="row row-cards-one">

            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
                    <div class="card">
                            <h5 class="card-header">{{ __('Popular Product(s)') }}</h5>
                            <div class="card-body">

                                <div class="table-responsive  dashboard-home-table">
                                    <table id="poproducts" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Featured Image') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Category') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($poproducts as $data)
                                            <tr>
                                            <td><img src="{{filter_var($data->photo, FILTER_VALIDATE_URL) ?$data->photo:asset('assets/images/products/'.$data->photo)}}"></td>
                                            <td>{{  mb_strlen(strip_tags($data->name),'UTF-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'UTF-8').'...' : strip_tags($data->name) }}</td>
                                            <td>{{ $data->category->name }}
                                                    @if(isset($data->subcategory))
                                                    <br>
                                                    {{ $data->subcategory->name }}
                                                    @endif
                                                    @if(isset($data->childcategory))
                                                    <br>
                                                    {{ $data->childcategory->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $data->type }}</td>

                                                <td> {{ $data->showPrice() }} </td>

                                                <td>
                                                    <div class="action-list"><a href="{{ route('admin-prod-edit',$data->id) }}"><i
                                                                class="fas fa-eye"></i> {{ __('Details') }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

            </div>

        </div>

    <div class="row row-cards-one">

            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12">
                    <div class="card">
                            <h5 class="card-header">{{ __('Recent Product(s)') }}</h5>
                            <div class="card-body">

                                <div class="table-responsive dashboard-home-table">
                                    <table id="pproducts" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                            <thead>
                                                    <tr>
                                                        <th>{{ __('Featured Image') }}</th>
                                                        <th>{{ __('Name') }}</th>
                                                        <th>{{ __('Category') }}</th>
                                                        <th>{{ __('Type') }}</th>
                                                        <th>{{ __('Price') }}</th>
                                                        <th></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pproducts as $data)
                                                    <tr>
                                                    <td><img src="{{filter_var($data->photo, FILTER_VALIDATE_URL) ?$data->photo:asset('assets/images/products/'.$data->photo)}}"></td>
                                                    <td>{{  mb_strlen(strip_tags($data->name),'UTF-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'UTF-8').'...' : strip_tags($data->name) }}</td>
                                                    <td>{{ $data->category->name }}
                                                        @if(isset($data->subcategory))
                                                        <br>
                                                        {{ $data->subcategory->name }}
                                                        @endif
                                                        @if(isset($data->childcategory))
                                                        <br>
                                                        {{ $data->childcategory->name }}
                                                        @endif
                                                    </td>
                                                        <td>{{ $data->type }}</td>
                                                        <td> {{ $data->showPrice() }} </td>
                                                        <td>
                                                            <div class="action-list"><a href="{{ route('admin-prod-edit',$data->id) }}"><i
                                                                        class="fas fa-eye"></i> {{ __('Details') }}</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

            </div>

    </div>

    <div class="row row-cards-one">

        <div class="col-md-12 col-sm-12 col-lg-6 col-xl-6">
            <div class="card">
                <h5 class="card-header">{{ __('Top Referrals') }}</h5>
                <div class="card-body">
                    <div class="admin-fix-height-card">
                         <div id="chartContainer-topReference"></div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-12 col-lg-6 col-sm-12 col-xl-6">
                <div class="card">
                        <h5 class="card-header">{{ __('Most Used OS') }}</h5>
                        <div class="card-body">
                        <div class="admin-fix-height-card">
                            <div id="chartContainer-os"></div>
                        </div>
                        </div>
                    </div>
        </div>

    </div>



</div>

@endsection

@section('scripts')

<!-- Load Chart.js 3.x from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<style>
.analytics-stat-box:hover {
    transform: translateY(-5px) !important;
}
.filter-btn {
    padding: 8px 18px !important;
    font-weight: 500 !important;
    font-size: 13px !important;
    border: none !important;
    background: transparent !important;
    color: #6c757d !important;
    transition: all 0.2s ease !important;
    border-radius: 6px !important;
    margin: 0 3px !important;
}
.filter-btn:hover {
    background: rgba(16, 185, 129, 0.08) !important;
    color: #10b981 !important;
}
.filter-btn.active {
    background: rgba(16, 185, 129, 0.18) !important;
    color: #10b981 !important;
    font-weight: 600 !important;
}
.filter-btn i {
    margin-right: 5px;
    font-size: 12px;
}

.chart-container {
    background: white !important;
}
</style>

<script type="text/javascript">
(function($) {
    "use strict";

    console.log('🚀 Analytics Chart Initializing...');
    console.log('📊 Chart.js loaded:', typeof Chart !== 'undefined' ? 'YES (v' + (Chart.version || '3.x') + ')' : 'NO');

    if (typeof Chart === 'undefined') {
        console.error('❌ Chart.js NOT loaded!');
        $('#analyticsChart').parent().html('<div class="alert alert-danger m-4"><i class="fas fa-exclamation-triangle"></i> Chart.js failed to load. Please refresh the page.</div>');
        return;
    }

    let analyticsChart = null;

    const chartData = {
        today: { labels: [], revenue: [], orders: [] },
        week: { labels: [], revenue: [], orders: [] },
        last30Days: { labels: [], revenue: [], orders: [] },
        monthly: { labels: [], revenue: [], orders: [] },
        yearly: { labels: [], revenue: [], orders: [] }
    };

    @php
        use Carbon\Carbon;

        // Today - hourly data
        $todayLabels = [];
        $todayRevenue = [];
        $todayOrders = [];
        for ($i = 0; $i < 24; $i++) {
            $todayLabels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
            $todayRevenue[] = round(App\Models\Order::where('status', 'completed')
                ->whereDate('created_at', Carbon::today())
                ->whereRaw('HOUR(created_at) = ?', [$i])
                ->sum('pay_amount'), 2);
            $todayOrders[] = App\Models\Order::whereDate('created_at', Carbon::today())
                ->whereRaw('HOUR(created_at) = ?', [$i])
                ->count();
        }

        // This Week - daily data
        $weekLabels = [];
        $weekRevenue = [];
        $weekOrders = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $weekLabels[] = $date->format('D, M d');
            $weekRevenue[] = round(App\Models\Order::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('pay_amount'), 2);
            $weekOrders[] = App\Models\Order::whereDate('created_at', $date)->count();
        }

        // Last 30 Days
        $last30Labels = [];
        $last30Revenue = [];
        $last30Orders = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = date("Y-m-d", strtotime('-' . $i . ' days'));
            $last30Labels[] = date("M d", strtotime('-' . $i . ' days'));
            $last30Revenue[] = round(App\Models\Order::where('status', 'completed')->whereDate('created_at', $date)->sum('pay_amount'), 2);
            $last30Orders[] = App\Models\Order::whereDate('created_at', $date)->count();
        }

        $monthlyLabels = [];
        $monthlyRevenue = [];
        $monthlyOrders = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[] = date("M", mktime(0, 0, 0, $i, 1));
            $monthlyRevenue[] = round(App\Models\Order::where('status', 'completed')->whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->sum('pay_amount'), 2);
            $monthlyOrders[] = App\Models\Order::whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->count();
        }

        $yearlyLabels = [];
        $yearlyRevenue = [];
        $yearlyOrders = [];
        for ($i = 4; $i >= 0; $i--) {
            $year = date('Y') - $i;
            $yearlyLabels[] = $year;
            $yearlyRevenue[] = round(App\Models\Order::where('status', 'completed')->whereYear('created_at', $year)->sum('pay_amount'), 2);
            $yearlyOrders[] = App\Models\Order::whereYear('created_at', $year)->count();
        }

        // Calculate totals for each period
        $todayTotalRevenue = array_sum($todayRevenue);
        $todayTotalOrders = array_sum($todayOrders);

        $weekTotalRevenue = array_sum($weekRevenue);
        $weekTotalOrders = array_sum($weekOrders);

        $last30TotalRevenue = array_sum($last30Revenue);
        $last30TotalOrders = array_sum($last30Orders);

        $monthlyTotalRevenue = array_sum($monthlyRevenue);
        $monthlyTotalOrders = array_sum($monthlyOrders);

        $yearlyTotalRevenue = array_sum($yearlyRevenue);
        $yearlyTotalOrders = array_sum($yearlyOrders);
    @endphp

    chartData.today.labels = {!! json_encode($todayLabels) !!};
    chartData.today.revenue = {!! json_encode($todayRevenue) !!};
    chartData.today.orders = {!! json_encode($todayOrders) !!};
    chartData.week.labels = {!! json_encode($weekLabels) !!};
    chartData.week.revenue = {!! json_encode($weekRevenue) !!};
    chartData.week.orders = {!! json_encode($weekOrders) !!};
    chartData.last30Days.labels = {!! json_encode($last30Labels) !!};
    chartData.last30Days.revenue = {!! json_encode($last30Revenue) !!};
    chartData.last30Days.orders = {!! json_encode($last30Orders) !!};
    chartData.monthly.labels = {!! json_encode($monthlyLabels) !!};
    chartData.monthly.revenue = {!! json_encode($monthlyRevenue) !!};
    chartData.monthly.orders = {!! json_encode($monthlyOrders) !!};
    chartData.yearly.labels = {!! json_encode($yearlyLabels) !!};
    chartData.yearly.revenue = {!! json_encode($yearlyRevenue) !!};
    chartData.yearly.orders = {!! json_encode($yearlyOrders) !!};

    // Store totals for each period
    const periodTotals = {
        today: {
            revenue: {{ $todayTotalRevenue }},
            orders: {{ $todayTotalOrders }}
        },
        week: {
            revenue: {{ $weekTotalRevenue }},
            orders: {{ $weekTotalOrders }}
        },
        30: {
            revenue: {{ $last30TotalRevenue }},
            orders: {{ $last30TotalOrders }}
        },
        monthly: {
            revenue: {{ $monthlyTotalRevenue }},
            orders: {{ $monthlyTotalOrders }}
        },
        yearly: {
            revenue: {{ $yearlyTotalRevenue }},
            orders: {{ $yearlyTotalOrders }}
        }
    };

    console.log('✅ Chart data loaded');

    $(document).ready(function() {
        setTimeout(() => {
            createChart('today');
            updateStatBoxes('today');
        }, 250);
    });

    $('.filter-btn').on('click', function(e) {
        e.preventDefault();
        const filter = $(this).data('filter');
        if (!$(this).hasClass('active')) {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            createChart(filter);
            updateStatBoxes(filter);
        }
    });

    function updateStatBoxes(filter) {
        const totals = periodTotals[filter];

        // Format revenue with currency
        const formattedRevenue = '$' + totals.revenue.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        // Update the stat boxes with animation
        $('#totalRevenue').fadeOut(200, function() {
            $(this).html(formattedRevenue).fadeIn(200);
        });

        $('#totalOrders').fadeOut(200, function() {
            $(this).html(totals.orders.toLocaleString('en-US')).fadeIn(200);
        });
    }

    function createChart(filter) {
        console.log('🎨 Creating chart:', filter);

        let data, period;
        if (filter === 'today') {
            data = chartData.today;
            period = 'Today\'s Performance - {{ date("F d, Y") }}';
        } else if (filter === 'week') {
            data = chartData.week;
            period = 'This Week\'s Performance';
        } else if (filter === '30') {
            data = chartData.last30Days;
            period = 'Last 30 Days Performance';
        } else if (filter === 'monthly') {
            data = chartData.monthly;
            period = 'Monthly Overview - {{ date("Y") }}';
        } else {
            data = chartData.yearly;
            period = 'Yearly Trends';
        }

        if (analyticsChart) analyticsChart.destroy();

        const canvas = document.getElementById('analyticsChart');
        if (!canvas) {
            console.error('❌ Canvas not found');
            return;
        }

        try {
            analyticsChart = new Chart(canvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: '💰 Revenue ($)',
                        data: data.revenue,
                        borderColor: '#667eea',
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                            gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
                            gradient.addColorStop(1, 'rgba(102, 126, 234, 0.0)');
                            return gradient;
                        },
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        yAxisID: 'y-revenue'
                    }, {
                        label: '🛒 Orders',
                        data: data.orders,
                        borderColor: '#f5576c',
                        backgroundColor: (context) => {
                            const ctx = context.chart.ctx;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                            gradient.addColorStop(0, 'rgba(245, 87, 108, 0.3)');
                            gradient.addColorStop(1, 'rgba(245, 87, 108, 0.0)');
                            return gradient;
                        },
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        pointBackgroundColor: '#f5576c',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 3,
                        yAxisID: 'y-orders'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    animation: { duration: 750, easing: 'easeInOutQuart' },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'end',
                            labels: {
                                padding: 20,
                                font: { size: 14, weight: '600', family: "'Onest', sans-serif" },
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 12,
                                color: '#2d3748'
                            }
                        },
                        title: {
                            display: true,
                            text: period,
                            font: { size: 18, weight: '700', family: "'Onest', sans-serif" },
                            color: '#667eea',
                            padding: { top: 15, bottom: 25 }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                            padding: 16,
                            titleFont: { size: 15, weight: '700' },
                            bodyFont: { size: 14 },
                            bodySpacing: 8,
                            cornerRadius: 12,
                            displayColors: true,
                            boxWidth: 12,
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 1,
                            callbacks: {
                                title: (context) => '📅 ' + context[0].label,
                                label: (context) => {
                                    let label = context.dataset.label;
                                    if (context.parsed.y !== null) {
                                        if (context.datasetIndex === 0) {
                                            label += ': $' + context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                        } else {
                                            label += ': ' + context.parsed.y.toLocaleString('en-US') + ' orders';
                                        }
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        'y-revenue': {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: 'rgba(0, 0, 0, 0.06)', drawBorder: false },
                            ticks: {
                                callback: (value) => '$' + value.toLocaleString('en-US'),
                                font: { size: 12, family: "'Onest', sans-serif" },
                                color: '#718096',
                                padding: 12
                            },
                            title: {
                                display: true,
                                text: '💰 Revenue ($)',
                                font: { size: 14, weight: '700', family: "'Onest', sans-serif" },
                                color: '#667eea',
                                padding: { bottom: 15 }
                            }
                        },
                        'y-orders': {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false, drawBorder: false },
                            ticks: {
                                callback: (value) => Math.floor(value),
                                font: { size: 12, family: "'Onest', sans-serif" },
                                color: '#718096',
                                padding: 12,
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: '🛒 Orders',
                                font: { size: 14, weight: '700', family: "'Onest', sans-serif" },
                                color: '#f5576c',
                                padding: { bottom: 15 }
                            }
                        },
                        x: {
                            grid: { color: 'rgba(0, 0, 0, 0.04)', drawBorder: false },
                            ticks: {
                                font: { size: 11, family: "'Onest', sans-serif" },
                                color: '#718096',
                                maxRotation: 45,
                                minRotation: 0,
                                padding: 10
                            }
                        }
                    }
                }
            });

            console.log('✅ Chart created successfully!');
        } catch (error) {
            console.error('❌ Chart error:', error);
        }
    }

    $('#poproducts, #pproducts').dataTable({
        ordering: false,
        lengthChange: false,
        searching: false,
        info: false,
        autoWidth: false,
        responsive: true,
        paging: false
    });

    if (typeof CanvasJS !== 'undefined') {
        new CanvasJS.Chart("chartContainer-topReference", {
            exportEnabled: true,
            animationEnabled: true,
            legend: { cursor: "pointer", horizontalAlign: "right", verticalAlign: "center", fontSize: 16, padding: { top: 20, bottom: 2, right: 20 }},
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                indexLabel: "#percent%",
                indexLabelFontColor: "white",
                indexLabelPlacement: "inside",
                dataPoints: [@foreach($referrals as $browser) {y:{{$browser->total_count}}, name: "{{$browser->referral}}"}, @endforeach]
            }]
        }).render();

        new CanvasJS.Chart("chartContainer-os", {
            exportEnabled: true,
            animationEnabled: true,
            legend: { cursor: "pointer", horizontalAlign: "right", verticalAlign: "center", fontSize: 16, padding: { top: 20, bottom: 2, right: 20 }},
            data: [{
                type: "pie",
                showInLegend: true,
                toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                indexLabel: "#percent%",
                indexLabelFontColor: "white",
                indexLabelPlacement: "inside",
                dataPoints: [@foreach($browsers as $browser) {y:{{$browser->total_count}}, name: "{{$browser->referral}}"}, @endforeach]
            }]
        }).render();
    }

})(jQuery);
</script>

@endsection
