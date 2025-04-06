<script setup>
import { usePage } from '@inertiajs/vue3';
const page = usePage()
const summary = page.props.list || {}
</script>

<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        <span class="summary-value">{{ summary['product'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Product</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        <span class="summary-value">{{ summary['category'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Category</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        <span class="summary-value">{{ summary['customer'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Customer</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        <span class="summary-value">{{ summary['invoice'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Invoice</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        $ <span class="summary-value">{{ summary['total'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Total Sale</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        $ <span class="summary-value">{{ summary['vat'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Vat Collection</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        $ <span class="summary-value">{{ summary['payable'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Total Payable</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 animated fadeIn p-2">
                <div class="card card-plain h-100 bg-white">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-9 col-lg-8 col-md-8 col-sm-9">
                                <div>
                                    <h5 class="mb-0 text-capitalize font-weight-bold">
                                        $ <span class="summary-value">{{ summary['discount'] }}</span>
                                    </h5>
                                    <p class="mb-0 text-sm">Total Discount</p>
                                </div>
                            </div>
                            <div class="col-3 col-lg-4 col-md-4 col-sm-3 text-end">
                                <div class="icon icon-shape bg-success shadow-sm float-end rounded-3">
                                    <img alt="" class="w-100" src="../../Assets/img/icon.svg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<style scoped></style>
