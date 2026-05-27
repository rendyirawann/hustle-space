@extends('backend.layout.app')
@section('title', 'Dashboard')
@section('content')

    <div class="mt-5 mb-10">

        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <!--begin::Card widget 20-->
                <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('{{ asset('assets/media/patterns/vector-1.png') }}')">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalUsers }}</span>
                            <!--end::Amount-->
                            <!--begin::Subtitle-->
                            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Total Users</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                </div>
                <!--end::Card widget 20-->
                <!--begin::Card widget 7-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $totalSubscriptions }}</span>
                            <!--end::Amount-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Active Subscriptions</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                </div>
                <!--end::Card widget 7-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
                <!--begin::Card widget 17-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center">
                                <!--begin::Amount-->
                                <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $totalFrames }}</span>
                                <!--end::Amount-->
                            </div>
                            <!--end::Info-->
                            <!--begin::Subtitle-->
                            <span class="text-gray-500 pt-1 fw-semibold fs-6">Custom Frames</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                </div>
                <!--end::Card widget 17-->
                <!--begin::Card widget 7-->
                <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #009ef7;background-image:url('{{ asset('assets/media/patterns/vector-1.png') }}')">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column">
                            <!--begin::Amount-->
                            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $totalMoments }}</span>
                            <!--end::Amount-->
                            <!--begin::Subtitle-->
                            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">Published Moments</span>
                            <!--end::Subtitle-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Header-->
                </div>
                <!--end::Card widget 7-->
            </div>
            <!--end::Col-->
            
            <!--begin::Col-->
            <div class="col-xl-6 mb-5 mb-xl-10">
                <!--begin::Table Widget 4-->
                <div class="card card-flush h-xl-100">
                    <!--begin::Card header-->
                    <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Recent Activities</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Latest activities from across the platform</span>
                        </h3>
                        <!--end::Title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-2">
                        @if(isset($recentActivities) && $recentActivities->count() > 0)
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-3">
                            <!--begin::Table body-->
                            <tbody>
                                @foreach($recentActivities as $activity)
                                <tr>
                                    <!--begin::Item-->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!--begin::Icon-->
                                            <div class="symbol symbol-45px me-5">
                                                <span class="symbol-label bg-light">
                                                    <i class="{{ $activity['icon'] }} fs-2x">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <!--end::Icon-->
                                            <!--begin::Title-->
                                            <div class="d-flex justify-content-start flex-column">
                                                <span class="text-gray-800 fw-bold fs-6">{{ $activity['message'] }}</span>
                                                <span class="text-gray-500 fw-semibold d-block fs-7">{{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}</span>
                                            </div>
                                            <!--end::Title-->
                                        </div>
                                    </td>
                                    <!--end::Item-->
                                </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                        @else
                        <div class="text-center py-5">
                            <span class="text-muted fs-6">No recent activities available.</span>
                        </div>
                        @endif
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Table Widget 4-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->

    </div>

@endsection
