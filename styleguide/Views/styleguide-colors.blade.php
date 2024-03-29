@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

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
                        <div>#cedddb</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-100"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">100</div>
                    <div>#9ebbb6</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-200"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">200</div>
                        <div>#6d9892</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-300"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">300</div>
                        <div>#3d766d</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">Green</div>
                        <div>#0c5449</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-500"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">500</div>
                        <div>#0b4a40</div>
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
                        <div>#08352f</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-800"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">800</div>
                        <div>#062b27</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-green-900"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">900</div>
                        <div>#05211e</div>
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
                        <div>#fff5d6</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-100"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">100</div>
                    <div>#ffebad</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-200"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">200</div>
                        <div>#ffe085</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-300"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">300</div>
                        <div>#ffd65c</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">Gold</div>
                    <div>#ffcc33</div></div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-500"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">500</div>
                        <div>#edbd2c</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-600"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">600</div>
                        <div>#dbae25</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-700"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">700</div>
                        <div>#c89f1f</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-800"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">800</div>
                        <div>#b69018</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gold-900"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">900</div>
                        <div>#a48111</div>
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
                    <div>#f4f4f5</div>
                </div>
            </div>
            <div class="space-y-1.5">
                <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-200"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">200</div>
                        <div>#e4e4e7</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-300"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">300</div>
                        <div>#d4d4d8</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">Gray</div>
                    <div>#a1a1aa</div></div>
                </div>
                <div class="space-y-1.5">
                        <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-500"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">500</div>
                        <div>#71717a</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-600"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">600</div>
                        <div>#52525b</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-700"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">700</div>
                        <div>#3f3f46</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-800"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">800</div>
                        <div>#27272a</div>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <div class="h-10 w-full rounded ring-1 ring-inset ring-black ring-opacity-0 bg-gray-900"></div>
                    <div class="px-0.5">
                        <div class="font-medium text-gray-900">900</div>
                        <div>#18181b</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
