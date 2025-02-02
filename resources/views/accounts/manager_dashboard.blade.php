@extends('layouts.accounts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success" id="successMessage">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger" id="errorMessage">
    <script>
        alert("{{ session('error') }}");
    </script>
    {{ session('error') }}
</div>
@endif
<style>
    .db {
        display: grid;
        grid-gap: 1.5em;
        padding: 1.5em;
        width: 100%;
    }

    .db__bars {
        display: grid;
        grid-template-columns: 2.5em repeat(7, 1fr);
        grid-template-rows: repeat(5, 1fr) 2.5em;
        align-items: center;
        justify-items: center;
        position: relative;
    }

    .db__bars-cell {
        text-align: center;
        width: 100%;
    }

    .db__bars-cell-bar {
        background-image: linear-gradient(var(--primary), var(--secondary), var(--tertiary));
        border-radius: 0.25em;
        margin: auto;
        overflow: hidden;
        position: relative;
        height: 15em;
        width: 50%;
        max-width: 3em;
    }

    .db__bars-cell-bar-fill {
        background-color: var(--gray2);
        position: absolute;
        top: 0;
        right: -1px;
        left: -1px;
        height: 100%;
        transition:
            background-color var(--trans-dur),
            transform var(--trans-dur) ease-in-out;
    }

    .db__bars-cell:nth-child(1) {
        grid-column: 2;
    }

    .db__bars-cell:nth-child(2) {
        grid-column: 3;
    }

    .db__bars-cell:nth-child(3) {
        grid-column: 4;
    }

    .db__bars-cell:nth-child(4) {
        grid-column: 5;
    }

    .db__bars-cell:nth-child(5) {
        grid-column: 6;
    }

    .db__bars-cell:nth-child(6) {
        grid-column: 7;
    }

    .db__bars-cell:nth-child(7) {
        grid-column: 8;
    }

    .db__bars-cell:nth-child(-n + 7) {
        grid-row: 1 / 6;
    }

    .db__bars-cell:nth-child(n + 8):nth-child(-n + 13) {
        align-self: start;
        text-align: right;
    }

    .db__bars-cell:nth-child(n + 14) {
        align-self: end;
    }

    .db__bubble {
        background-color: var(--primary);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 12em;
        height: 12em;
        transform: translate(-50%, -50%) translate(-3em, -2em);
    }

    .db__bubble:nth-child(2) {
        background-color: var(--secondary);
        font-size: 0.9em;
        width: 9rem;
        height: 9rem;
        transform: translate(-50%, -50%) translate(5rem, -1rem);
    }

    .db__bubble:nth-child(3) {
        background-color: var(--tertiary);
        font-size: 0.8em;
        width: 7rem;
        height: 7rem;
        transform: translate(-50%, -50%) translate(1rem, 4.5rem);
    }

    .db__bubble-text {
        color: hsl(0, 0%, 100%);
        text-align: center;
    }

    .db__bubble-value {
        font-size: 2.25em;
    }

    .db__bubbles {
        position: relative;
        height: 17em;
    }

    .db__cell,
    .db__select {
        background-color: hsla(0, 0%, 100%, 0.5);
        backdrop-filter: blur(20px);
        box-shadow:
            0 0 0 1px hsla(0, 0%, 100%, 0.5) inset,
            0 0 0 2px hsla(0, 0%, 100%, 0) inset,
            0 0 0.75em hsl(0, 0%, 0%, 0.3);
        -webkit-backdrop-filter: blur(20px);
    }

    .db__cell {
        border-radius: 0.5em;
        padding: 1.5em 1.25em;
        display: flex;
        flex-direction: column;
        transition:
            background-color var(--trans-dur),
            box-shadow var(--trans-dur);
    }

    .db__counter {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-grow: 1;
    }

    .db__counter-value,
    .db__heading,
    .db__subheading {
        font-weight: 500;
    }

    .db__counter-label {
        line-height: 1;
        margin-left: 0.75em;
        text-align: right;
    }

    .db__counter-value {
        font-size: 2em;
        line-height: 1;
    }

    .db__heading {
        font-size: 2em;
    }

    .db__order {
        display: flex;
        padding: 1em 0;
    }

    .db__order:not(:last-child) {
        box-shadow: 0 1px 0 hsla(0, 0%, 50%, 0.3);
    }

    .db__order-cat,
    .db__order-name {
        margin-right: 1em;
    }

    .db__order-cat {
        background-color: hsla(var(--hue), 90%, 55%, 0.2);
        border-radius: 50%;
        display: grid;
        place-items: center;
        align-self: center;
        width: 2.75em;
        height: 2.75em;
        transition: background-color var(--trans-dur);
    }

    .db__order-cat-icon {
        color: var(--primary);
        width: 1.5em;
        height: 1.5em;
        transition: color var(--trans-dur);
    }

    .db__order-name {
        flex-grow: 1;
    }

    .db__product {
        display: flex;
        justify-content: space-between;
    }

    .db__product-details {
        width: 33%;
    }

    .db__product-details+.db__product-details {
        text-align: right;
        width: 67%;
    }

    .db__product-detail-line {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .db__product-table {
        border-collapse: collapse;
        text-align: left;
        width: 100%;
    }

    .db__product-table th,
    .db__product-table td {
        padding: 1em 0.5em 1em 0;
    }

    .db__product-table th {
        font-weight: 400;
    }

    .db__product-table th:nth-child(odd) {
        width: 30%;
    }

    .db__product-table th:nth-child(even) {
        width: 20%;
    }

    .db__product-table td {
        max-width: 1px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .db__product-table th,
    .db__product-table tr:not(:last-child) td {
        box-shadow: 0 -1px 0 hsla(0, 0%, 50%, 0.3) inset;
    }

    .db__product-table thead,
    .db__product-table td+td {
        display: none;
    }

    .db__progress {
        background-image: linear-gradient(90deg, var(--primary), var(--secondary), var(--tertiary));
        height: 0.25em;
        margin-bottom: 1.25em;
        overflow: hidden;
        position: relative;
    }

    .db__progress-fill {
        background-color: var(--gray2);
        position: absolute;
        top: -1px;
        right: 0;
        bottom: -1px;
        left: 0;
        transition:
            background-color var(--trans-dur),
            transform var(--trans-dur) ease-in-out;
    }

    .db__select {
        border-radius: 0.2em;
        display: inline-flex;
        align-items: center;
        margin-right: 1em;
        padding: 0.75em 1.5em;
        transition:
            background-color var(--trans-dur),
            box-shadow var(--trans-dur),
            color var(--trans-dur);
    }

    .db__select:focus {
        outline: transparent;
    }

    .db__select:focus,
    .db__select:hover {
        background-color: hsla(0, 0%, 100%, 0.7);
    }

    .db__select:last-child {
        margin-right: 0;
    }

    .db__select::after {
        box-shadow: -0.125em -0.125em 0 0 currentColor inset;
        content: "";
        display: inline-block;
        margin-left: 1.25em;
        width: 0.5em;
        height: 0.5em;
        transform: translateY(-0.125em) rotate(45deg);
    }

    .db__select-icon {
        margin-right: 0.75em;
        width: 1.5em;
        height: 1.5em;
    }

    .db__status {
        transition: color var(--trans-dur);
    }

    .db__status::before {
        background-color: currentColor;
        border-radius: 50%;
        content: "";
        display: inline-block;
        margin-right: 0.5em;
        width: 0.5em;
        height: 0.5em;
        vertical-align: 0.1em;
    }

    .db__status--green {
        color: hsl(123, 90%, 25%);
    }

    .db__status--orange {
        color: hsl(33, 90%, 35%);
    }

    .db__status--red {
        color: hsl(3, 90%, 35%);
    }

    .db__subheading {
        font-size: 1.5em;
        line-height: 1;
        margin-bottom: 1.5rem;
    }

    .db__toolbar {
        color: var(--gray1);
        min-height: 3em;
    }

    .db__toolbar-btns {
        margin-top: 1em;
    }

    .db__top-stat {
        font-size: 1em;
        font-weight: normal;
        margin-bottom: 1em;
    }

    small,
    time,
    .db__bars-cell,
    .db__product-table th,
    .db__top-stat {
        color: var(--gray7);
        transition:
            background-color var(--trans-dur),
            color var(--trans-dur);
    }

    /* `:focus-visible` support */
    @supports selector(:focus-visible) {
        .db__select:focus {
            background-color: hsla(0, 0%, 100%, 0.5);
        }

        .db__select:focus-visible,
        .db__select:hover {
            background-color: hsla(0, 0%, 100%, 0.7);
        }
    }

    /* Dark theme */
    @media (prefers-color-scheme: dark) {

        body,
        button {
            color: var(--gray1);
        }

        .db__bars-cell-bar-fill,
        .db__progress-fill {
            background-color: var(--gray9);
        }

        .db__order-cat {
            background-color: hsla(var(--hue), 90%, 65%, 0.2);
        }

        .db__order-cat-icon {
            color: hsl(var(--hue), 90%, 65%);
        }

        .db__cell,
        .db__select {
            background-color: hsla(var(--hue), 10%, 10%, 0.7);
            box-shadow:
                0 0 0 1px hsla(var(--hue), 10%, 10%, 0.7) inset,
                0 0 0 2px hsla(0, 0%, 100%, 0.2) inset,
                0 0 0.75em hsl(var(--hue), 10%, 10%, 0.3);
        }

        .db__select:focus,
        .db__select:hover {
            background-color: hsla(var(--hue), 10%, 25%, 0.7);
        }

        .db__status--green {
            color: hsl(123, 90%, 40%);
        }

        .db__status--orange {
            color: hsl(33, 90%, 70%);
        }

        .db__status--red {
            color: hsl(3, 90%, 70%);
        }

        small,
        time,
        .db__bars-cell,
        .db__product-table th,
        .db__top-stat {
            color: var(--gray3);
        }

        /* `:focus-visible` support */
        @supports selector(:focus-visible) {
            .db__select:focus {
                background-color: hsla(var(--hue), 10%, 10%, 0.7);
            }

            .db__select:focus-visible,
            .db__select:hover {
                background-color: hsla(var(--hue), 10%, 25%, 0.7);
            }
        }
    }

    /* Tablet */
    @media (min-width: 768px) {
        .db {
            grid-template-columns: 1fr 1fr 2fr;
            grid-template-areas:
                "a a g"
                "b b g"
                "c d g"
                "e e h"
                "e e h"
                "f f h";
        }

        .db__bubble {
            width: 16em;
            height: 16em;
            transform: translate(-50%, -50%) translate(-4em, -2em);
        }

        .db__bubble:nth-child(2) {
            width: 12rem;
            height: 12rem;
            transform: translate(-50%, -50%) translate(6rem, -1rem);
        }

        .db__bubble:nth-child(3) {
            width: 8rem;
            height: 8rem;
            transform: translate(-50%, -50%) translate(1rem, 6rem);
        }

        .db__bubbles {
            height: 20em;
        }

        .db__cell:nth-child(2) {
            grid-area: b;
        }

        .db__cell:nth-child(3) {
            grid-area: c;
        }

        .db__cell:nth-child(4) {
            grid-area: d;
        }

        .db__cell:nth-child(5) {
            grid-area: e;
        }

        .db__cell:nth-child(6) {
            grid-area: f;
        }

        .db__cell:nth-child(7) {
            grid-area: g;
        }

        .db__cell:nth-child(8) {
            grid-area: h;
        }

        .db__product-table thead {
            display: table-header-group;
        }

        .db__product-table td {
            display: none;
        }

        .db__product-table td+td {
            display: table-cell;
        }

        .db__toolbar {
            grid-area: a;
        }
    }

    /* Desktop */
    @media (min-width: 1024px) {
        .db__toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .db__toolbar-btns {
            margin-top: 0;
        }
    }

    @media (min-width: 1280px) {
        .db {
            grid-template-columns: 1fr 1fr 1fr 2fr;
            grid-template-areas:
                "a a a g"
                "b c d g"
                "e e e g"
                "e e e h"
                "f f f h"
                "f f f h";
        }
    }
    .db__cell {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 10px;
        background: #f1f3f4;
        padding: 14px 14px;
    }

    .box1 {
        background-image: linear-gradient(to right, #f7769d, #fda682);
        color: #fff;
    }

    .box2 {
        background-image: linear-gradient(to right, #7ccdff, #7095ff);
        color: #fff;
    }

    .box3 {
        background-image: linear-gradient(to right, #c07dfe, #f19ff6);
        color: #fff;
    }
    .db__bars {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    .db__bars-cell {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin: 5px 0;
    }
    .db__bars-cell-bar {
        position: relative;
        width: 100%;
        height: 20px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
    }
    .db__bars-cell-bar-fill {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #007bff;
    }
    .db__bars-cell-bar-fill::after {
        content: attr(title);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 3px 6px;
        border-radius: 3px;
        font-size: 12px;
    }
    .db__bars-cell > time {
        margin-left: 10px;
        font-size: 12px;
        color: #666;
    }

</style>
<section class="content">
    <div class="body_scroll">
        <div class="block-header" style="padding: 16px 15px !important;">
            <h2><b>Status Data</b></h2>
        </div>
            <!-- Tab buttons -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab"
                        aria-controls="dashboard" aria-selected="true"
                        style="font-size: 15px;color: #000;font-weight:500">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="carriers-tab" data-bs-toggle="tab" href="#carriers" role="tab"
                        aria-controls="carriers" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Carriers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="customers-tab" data-bs-toggle="tab" href="#customers" role="tab"
                        aria-controls="customers" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="dispatchers-tab" data-bs-toggle="tab" href="#dispatchers" role="tab"
                        aria-controls="dispatchers" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Dispatchers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="loads-tab" data-bs-toggle="tab" href="#loads" role="tab"
                        aria-controls="loads" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Load Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab"
                        aria-controls="sales" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Sales Reps</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#log" role="tab"
                        aria-controls="sales" aria-selected="false"
                        style="font-size: 15px;color: #000;font-weight:500">Load Complete Logs</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <div class="main">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="db__cell">
                                <div class="d-flex justify-content-between">
                                <h1 class="db__heading">Overview</h1>
                                </div>
                                   
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <div class="db__cell dynamic-data box1 mt-3">
                                                <h2 class="db__top-stat">Total Revenue</h2>
                                                <div class="db__progress">
                                                    <div class="db__progress-fill" style="transform:translateX(15%)">
                                                    </div>
                                                </div>
                                                <div class="db__counter">
                                                    <div class="db__counter-value" title="$3,330,050.90">${{ $revenue }}
                                                    </div>
                                                    <div class="db__counter-label">
                                                        <strong>+{{ $percentIncrease }}%</strong><br><small>vs
                                                            yesterday</small>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="db__cell dynamic-data box2 mt-3">
                                                <h2 class="db__top-stat">Total Carrier</h2>
                                                <div class="db__progress">
                                                    <div class="db__progress-fill" style="transform:translateX(20%)">
                                                    </div>
                                                </div>
     
                                                <div class="db__counter">
                                                    <div class="db__counter-value">
                                                        <span>{{ $carrierCountDashboard }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="db__cell dynamic-data box3 mt-3">
                                                <h2 class="db__top-stat">Total Margin <span style="font-size:10px">(Customer Amt - Carrier Amt)</span></h2>
                                                <div class="db__progress">
                                                    <div class="db__progress-fill" style="transform:translateX(42%)">
                                                    </div>
                                                </div>
                                                <div class="db__counter">
                                                    <div class="db__counter-value">
                                                         <span>${{ $finalTotal }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <div class="db__cell dynamic-data box1 mt-3">
                                                <h2 class="db__top-stat">Total Shippers</h2>
                                                <div class="db__progress">
                                                    <div class="db__progress-fill" style="transform:translateX(15%)">
                                                    </div>
                                                </div>
                                                <div class="db__counter">
                                                    <div class="db__counter-value" title="$3,330,050.90">{{ $shipperCountDashboard }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="db__cell dynamic-data box2 mt-3">
                                                <h2 class="db__top-stat">Total Load in 24 Hours</h2>
                                                <div class="db__progress">
                                                    <div class="db__progress-fill" style="transform:translateX(20%)">
                                                    </div>
                                                </div>
     
                                                <div class="db__counter">
                                                    <div class="db__counter-value">
                                                        <span>{{ $loadCount }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="db__cell dynamic-data box3 mt-3">
                                                <h2 class="db__top-stat">New Customer Added</h2>
                                                <div class="db__progress">
                                                    <div class="db__progress-fill" style="transform:translateX(42%)">
                                                    </div>
                                                </div>
                                                <div class="db__counter">
                                                    <div class="db__counter-value">
                                                        <span>{{ $newCoustmerAdded }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="db__cell dynamic-data mt-3">
                                    <h2 class="db__subheading">Sales</h2>
                                    <canvas id="salesChart"></canvas>
                                </div>
                                
                                <div class="db__cell dynamic-data mt-3">
                                    <h2 class="db__subheading">Best Performance Broker</h2>
                                    <table class="table table-responsive table-bordered table-hover dataTable js-exportable table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="color: #fff !important;">Broker</th>
                                                <th style="color: #fff !important;">No of Load</th>
                                                <th style="color: #fff !important;">Total Carrier Pay</th>
                                                <th style="color: #fff !important;">Status</th>
                                                <th style="color: #fff !important;">Margin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bestPerformance as $index => $bpc)
                                            <tr>
                                                <td style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $bpc->name }}</td>
                                                <td style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $bpc->load_number }}</td>
                                                <td style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $bpc->total_fee }}</td>
                                                <td style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $bpc->load_status }}</td>
                                                <td style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $bpc->load_final_carrier_fee }}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <div class="db__cell dynamic-data mt-3">
                                        <h2 class="db__subheading">Number of Shippers and Carriers</h2>
                                        <div class="db__bubbles">
                                            <div class="db__bubble">
                                                <span class="db__bubble-text">Loads<br><strong class="db__bubble-value">{{ $count }}</strong><br>Total Loads</span>
                                            </div>
                                            <div class="db__bubble">
                                                <span class="db__bubble-text">Agents<br><strong class="db__bubble-value">{{ $agents }}</strong><br>Total Agents</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="db__cell dynamic-data mt-3">
                                        <h2 class="db__subheading">Maximum Loads With Customers</h2>
                                        @foreach($topMaximumLoadCustomers as $loadCount)
                                        <div class="db__order">
                                            <div class="db__order-cat">
                                                <img src="{{ asset('assets/images/dashboard_customer.png') }}" alt=""
                                                    style="width: 32px;height: 32px;">
                                            </div>
                                            <div class="db__order-name">
                                                {{ $loadCount-> load_bill_to}}<br>
                                            </div>
                                            <div><strong>{{ $loadCount->load_count }} Loads</strong></div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="carriers" role="tabpanel" aria-labelledby="carriers-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th style="color: #fff !important;">Carrier</th>
                                        <th style="color: #fff !important;"># of Load</th>
                                        <th style="color: #fff !important;">Gross Revenue</th>
                                        <th style="color: #fff !important;">Carrier Pay</th>
                                        <th style="color: #fff !important;">Profit</th>
                                        <th style="color: #fff !important;">Miles</th>
                                        <th style="color: #fff !important;">Revenue / Mile</th>
                                        <th style="color: #fff !important;">Pay / Mile</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($totalRevenueloadcarrier as $LoadCarrier)
                                    @php
                                    $finalRate = $LoadCarrier->total_revenue - $LoadCarrier->revenue_difference;
                                    @endphp
                                    <tr>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $LoadCarrier->load_carrier }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $LoadCarrier->load_count }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $LoadCarrier->total_revenue }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $LoadCarrier->revenue_difference }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $finalRate }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">-</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">-</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">-</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>

                </div>

                <div class="tab-pane fade" id="customers" role="tabpanel" aria-labelledby="customers-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Customer</th>
                                    <th style="color: #fff !important;">Gross Revenue</th>
                                    <th style="color: #fff !important;">Carrier Pay</th>
                                    <th style="color: #fff !important;">Margin</th>
                                    <th style="color: #fff !important;">No. Of Loads</th>
                                    <th style="color: #fff !important;">Open Loads</th>
                                    <th style="color: #fff !important;">Delivered Loads</th>
                                    <th style="color: #fff !important;">Completed Loads</th>
                                    <th style="color: #fff !important;">Approved Limit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totalRevenueCustomer as $rc)
                                @php
                                $finalRate = $rc->total_revenue - $rc->revenue_difference;
                                @endphp
                                <tr>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $rc->load_bill_to }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ number_format($rc->total_revenue, 2) }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ number_format($rc->revenue_difference, 2) }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ number_format($finalRate, 2) }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $rc->load_count }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $rc->open_load_count }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $rc->deliverd_load_count }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $rc->completed_load_count }}</td>
                                    <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ number_format($rc->adv_customer_credit_limit, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="tab-pane fade" id="dispatchers" role="tabpanel" aria-labelledby="customers-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover js-basic-example dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th style="color: #fff !important;">Dispatcher</th>
                                        <th style="color: #fff !important;">No of Load</th>
                                        <th style="color: #fff !important;">Revenue</th>
                                        <th style="color: #fff !important;">Carrier Amount</th>
                                        <th style="color: #fff !important;">Margin </th>
                                        <th style="color: #fff !important;">Open Loads</th>
                                        <th style="color: #fff !important;">Delivered Loads</th>
                                        <th style="color: #fff !important;">Invoiced Loads</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($totalRevenueCarrier as $revenue)
                                    @php
                                    $finalRate = $revenue->total_revenue - $revenue->revenue_difference;
                                    @endphp

                                    <tr>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $revenue->name }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $revenue->load_count }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $revenue->total_revenue }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">${{ number_format($revenue->sum_load_final_carrier_fee, 2) }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $revenue->revenue_difference }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $revenue->open_load_count }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $revenue->delivered_load_count }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $revenue->invoiced_load_count }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>



                <div class="tab-pane fade" id="loads" role="tabpanel" aria-labelledby="customers-tab">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover js-basic-example dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Load No</th>
                                    <th style="color: #fff !important;">Status</th>
                                    <th style="color: #fff !important;">Carrier</th>
                                    <th style="color: #fff !important;">Created</th>
                                    <th style="color: #fff !important;">Dispatcher</th>
                                    <th style="color: #fff !important;">Customer</th>
                                    <th style="color: #fff !important;">Shipper</th>
                                    <th style="color: #fff !important;">Ship Date</th>
                                    <th style="color: #fff !important;">Location</th>
                                    <th style="color: #fff !important;">Consignee</th>
                                    <th style="color: #fff !important;">Delevery Date</th>
                                    <th style="color: #fff !important;">Delivery Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dashboard as $load)
                                    @php
                                        $shipper = json_decode($load->load_shipperr, true);
                                        $consignee = json_decode($load->load_consignee, true);
                                        $shipper_appointment = json_decode($load->load_shipper_appointment, true);
                                        $shipper_location = json_decode($load->load_shipper_location, true); 
                                        $consignee_location = json_decode($load->load_consignee_location, true); 
                                        $consignee_appointment = json_decode($load->load_consignee_appointment, true);
                                    @endphp

                                            <tr>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $load->load_number }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $load->load_status }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $load->load_carrier }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $load->created_at }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $load->user->name }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $load->load_bill_to }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ isset($shipper[0]['name']) ? $shipper[0]['name'] : '' }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">
                                            @if(isset($shipper_appointment[0]['appointment']))
                                                {{ \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('Y-m-d') }}
                                            @else
                                                'Old Data'
                                            @endif
                                        </td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ isset($shipper_location[0]['location']) ? $shipper_location[0]['location'] : 'No Location Entered' }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ isset($consignee[0]['name']) ? $consignee[0]['name'] : 'Old Data' }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('y-m-d') : '' }}</td>
                                        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ isset($consignee_location[0]['location']) ? $consignee_location[0]['location'] : 'No Location Entered' }}</td>
                                    </tr>
                                    @endforeach
                            </tbody>           
                        </table>
                    </div>
                </div>


                <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="customers-tab">
                  <div class="table-responsive">
                     <table class="table table-bordered table-hover js-basic-example dataTable no-footer">
                        <thead>
                            <tr>
                                <th style="color: #fff !important;">Sales Rep</th>
                                <th style="color: #fff !important;">No of Load</th>
                                <th style="color: #fff !important;">Gross Revenue</th>
                                <th style="color: #fff !important;">Carrier Pay</th>
                                <th style="color: #fff !important;">Margin</th>
                                <th style="color: #fff !important;">Open Load</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalRevenueBroker as $r)
                            @php
                            $finalRate = $r->total_revenue - $r->revenue_difference;
                            @endphp

                            <tr>
                                <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $r->name }}</td>
                                <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $r->load_count }}</td>
                                <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $r->total_revenue }}</td>
                                <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $finalRate }}</td>
                                <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $r->revenue_difference }}</td>
                                <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $r->open_load_count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>

                <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="customers-tab">
                   <div class="table-responsive">
                         <table class="table table-bordered table-hover js-basic-example dataTable no-footer">
                            <thead>
                                <tr>
                                    <th style="color: #fff !important;">Load #</th>
                                    <th style="color: #fff !important;">Agent Name</th>
                                    <th style="color: #fff !important;">Load Status</th>
                                    <th style="color: #fff !important;">Load Create Date</th>
                                    <th style="color: #fff !important;">Customer Name</th>
                                    <th style="color: #fff !important;">Carrier Name</th>
                                    <th style="color: #fff !important;">Pickup Location</th>
                                    <th style="color: #fff !important;">Unloading Location</th>
                                    <th style="color: #fff !important;">Load Type</th>
                                    <th style="color: #fff !important;">Carrier Advance Payment</th>
                                    <th style="color: #fff !important;">Delivery Date</th>
                                    <th style="color: #fff !important;">Actual Delivery Date</th>
                                    <th style="color: #fff !important;">Carrier Due Date</th>
                                    <th style="color: #fff !important;">Carrier Mark Payment Date</th>
                                    <th style="color: #fff !important;">Carrier Fee</th>
                                    <th style="color: #fff !important;">Shipper Rate</th>
                                    <th style="color: #fff !important;">Invoice No</th>
                                    <th style="color: #fff !important;">Invoice Date</th>
                                    <th style="color: #fff !important;">Customer Payment Received Date</th>
                                    <th style="color: #fff !important;">Customer Rate</th>
                                    <th style="color: #fff !important;">Carrier Rate</th>
                                    <th style="color: #fff !important;">Margin</th>
                                </tr>
                            </thead>
                            <tbody>
    @foreach($dashboard as $log)
    @php
        $shipper = json_decode($log->load_shipperr, true);
        $consignee = json_decode($log->load_consignee, true);
        $shipper_appointment = json_decode($log->load_shipper_appointment,true);
        $shipper_location = json_decode($log->load_shipper_location,true);
        $appointment = isset($shipper_location[0]['appointment']) ? $shipper_location[0]['appointment'] : '';
        $consignee_location = json_decode($log->load_consignee_location,true); 
        $consignee_appointment = json_decode($log->load_consignee_appointment,true);
    @endphp
    <tr>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_number }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->user->name }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_status }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->created_at }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_bill_to }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_carrier }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $shipper_location[0]['location'] ?? '' }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $consignee_location[0]['location'] ?? '' }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_type_two }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_advance_payment }}</td>
        @php
            // Get the last key of the consignee appointment array
            $lastKey = array_key_last($consignee_appointment);

            // Check if the appointment date is not empty
            $appointmentDate = !empty($consignee_appointment[$lastKey]['appointment']) ? $consignee_appointment[$lastKey]['appointment'] : null;

            // Format the date if it exists
            $formattedDate = $appointmentDate ? (new DateTime($appointmentDate))->format('m-d-Y') : '';
        @endphp
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">
            {{ $formattedDate }}
        </td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_actual_delivery_date }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_carrier_due_date }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_carrier_due_date_on }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_final_carrier_fee }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->shipper_load_final_rate }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->invoice_number }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->invoice_date }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->invoice_status_date }}</td>
        @php
            // Assign default values if null
            $shipperLoadFinalRate = $log->shipper_load_final_rate ?? 0;
            $loadFinalCarrierFee = $log->load_final_carrier_fee ?? 0;

            // Ensure values are numeric
            $shipperLoadFinalRate = is_numeric($shipperLoadFinalRate) ? $shipperLoadFinalRate : 0;
            $loadFinalCarrierFee = is_numeric($loadFinalCarrierFee) ? $loadFinalCarrierFee : 0;

            // Calculate margin
            $margin = $shipperLoadFinalRate - $loadFinalCarrierFee;
        @endphp
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->shipper_load_final_rate }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ $log->load_final_carrier_fee }}</td>
        <td class="dynamic-data" style="padding: 7px 10px !important; vertical-align: middle !important;">{{ number_format($margin, 2) }}</td>
    </tr>
    @endforeach
</tbody>

                        </table>
                </div>
     </div>
            </div>
</section>
<div class="modal fade" id="datePickerModal" tabindex="-1" role="dialog" aria-labelledby="datePickerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="datePickerModalLabel">Select Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Date input field -->
                <input id="dashboard_name" type="date" name="dashboard_name" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="getDate()">Select</button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
</script>

<script>
    $(document).ready(function () {
        // Initialize Bootstrap tabs
        var tabTriggerEl = document.getElementById('myTab');    
        var tab = new bootstrap.Tab(tabTriggerEl);
        tab.show();
    });
</script>

<script>
    // Wait for the document to be fully loaded
    document.addEventListener("DOMContentLoaded", function () {
        // Get all anchor tags in the document
        var anchorTags = document.querySelectorAll("a");

        // Loop through each anchor tag
        anchorTags.forEach(function (anchor) {
            // Set text decoration to unset
            anchor.style.textDecoration = "unset";
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Retrieve the last active tab from local storage
        var lastActiveTab = localStorage.getItem('lastActiveTab');

        // If a last active tab is found, set it as active
        if (lastActiveTab) {
            $('#myTab a[href="' + lastActiveTab + '"]').tab('show');
        }

        // Store the active tab in local storage when a tab is clicked
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var targetTab = e.target.getAttribute('href');
            localStorage.setItem('lastActiveTab', targetTab);
        });

        // Initialize DataTables for both tables
        $('#dataTableOpen').DataTable();
        $('#dataTableDelivered').DataTable();
    });
</script>


<script>
    var datepickerButton = document.getElementById('datepicker-button');
    var selectedDateInput = document.getElementById('selected-date');

    datepickerButton.addEventListener('click', function () {
        var today = new Date();
        var year = today.getFullYear();
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var day = String(today.getDate()).padStart(2, '0');
        var currentDate = year + '-' + month + '-' + day;
        selectedDateInput.value = currentDate;
        var event = new Event('change');
        selectedDateInput.dispatchEvent(event);
    });
</script>

<script>
    function getDate() {
        var selectedDate = document.getElementById("dashboard_name").value;
        console.log("Selected date:", selectedDate);
        // Add your logic to handle the selected date here
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const salesData = @json($salesData);
        
        const labels = salesData.map(data => new Date(data.date).toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' }));
        const salesValues = salesData.map(data => data.shipper_rate - data.carrier_fee);

        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales',
                    data: salesValues,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true,
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales ($)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `$${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection