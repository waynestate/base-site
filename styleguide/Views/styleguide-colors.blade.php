@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <div class="content">
        <p>Example usage: <code>text-green-600</code> or <code>text-gold</code>. When you need to use our palette in CSS where it's not an existing Tailwind property like a gradient stop, use <code>theme('colors.gold.DEFAULT')</code> or <code>theme('colors.gold.500')</code>.</p>
        <div class="flex flex-col space-y-3 sm:flex-row text-xs sm:space-y-0 sm:space-x-4">
            <div class="w-32 flex-shrink-0">
                <div class="h-10 flex flex-col justify-center">
                    <div class="text-sm font-semibold text-gray-900">Green</div>
                    <code class="text-xs text-gray-900">colors.green</code>
                </div>
            </div>
            <div class="min-w-0 flex-1 grid grid-cols-2 md:grid-cols-5 2xl:grid-cols-10 gap-x-4 gap-y-3 2xl:gap-x-2">
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-50"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">50</div>
                        <div>#CEDDDB</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-100"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">100</div>
                    <div>#9EBBB6</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-200"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">200</div>
                        <div>#6D9892</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-300"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">300</div>
                        <div>#3D766D</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">Green</div>
                    <div>#0C5449</div></div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-500"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">500</div>
                        <div>#0B4A40</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-600"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">600</div>
                        <div>#094038</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-700"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">700</div>
                        <div>#08352F</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-800"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">800</div>
                        <div>#062B27</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-900"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">900</div>
                        <div>#05211E</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col space-y-3 sm:flex-row text-xs sm:space-x-4">
            <div class="w-32 flex-shrink-0">
                <div class="h-10 flex flex-col justify-center">
                    <div class="text-sm font-semibold text-gray-900">Gold</div>
                    <code class="text-xs text-gray-900">colors.gold</code>
                </div>
            </div>
            <div class="min-w-0 flex-1 grid grid-cols-2 md:grid-cols-5 2xl:grid-cols-10 gap-x-4 gap-y-3 2xl:gap-x-2">
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-50"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">50</div>
                        <div>#FFF5D6</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-100"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">100</div>
                    <div>#FFEBAD</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-200"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">200</div>
                        <div>#FFE085</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-300"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">300</div>
                        <div>#FFD65C</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">Gold</div>
                    <div>#FFCC33</div></div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-500"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">500</div>
                        <div>#EDBD2C</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-600"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">600</div>
                        <div>#DBAE25</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-700"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">700</div>
                        <div>#C89F1F</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-800"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">800</div>
                        <div>#B69018</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-900"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">900</div>
                        <div>#A48111</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col space-y-3 sm:flex-row text-xs sm:space-x-4">
            <div class="w-32 flex-shrink-0">
                <div class="h-10 flex flex-col justify-center">
                    <div class="text-sm font-semibold text-gray-900">Gray</div>
                    <code class="text-xs text-gray-900">colors.gray</code>
                </div>
            </div>
            <div class="min-w-0 flex-1 grid grid-cols-2 md:grid-cols-5 2xl:grid-cols-10 gap-x-4 gap-y-3 2xl:gap-x-2">
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-50"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">50</div>
                        <div>#FAFAFA</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-100"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">100</div>
                    <div>#F5F5F5</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-200"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">200</div>
                        <div>#E5E5E5</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-300"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">300</div>
                        <div>#D4D4D4</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">Gray</div>
                    <div>#A3A3A3</div></div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-500"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">500</div>
                        <div>#737373</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-600"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">600</div>
                        <div>#525252</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-700"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">700</div>
                        <div>#404040</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-800"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">800</div>
                        <div>#262626</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-900"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">900</div>
                        <div>#171717</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
