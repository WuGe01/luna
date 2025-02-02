<?php

/**
 * Global variables
 * --------------------------------------------------------------
 * @var  $app       AppContext      Application context.
 * @var  $vm        \Lyrasoft\Luna\Module\Admin\Language\LanguageListView The view model object.
 * @var  $uri       SystemUri       System Uri information.
 * @var  $chronos   ChronosService  The chronos datetime service.
 * @var  $nav       Navigator       Navigator object to build route.
 * @var  $asset     AssetService    The Asset manage service.
 * @var  $lang      LangService     The language translation service.
 */

declare(strict_types=1);

use Lyrasoft\Luna\Module\Admin\Language\LanguageListView;use Windwalker\Core\Application\AppContext;use Windwalker\Core\Asset\AssetService;use Windwalker\Core\DateTime\ChronosService;use Windwalker\Core\Language\LangService;use Windwalker\Core\Router\Navigator;use Windwalker\Core\Router\SystemUri;

/**
 * @var \Lyrasoft\Luna\Entity\Language $entity
 */

$workflow = $app->service(\Unicorn\Workflow\BasicStateWorkflow::class);

$localeService = $app->service(\Lyrasoft\Luna\Services\LocaleService::class);
?>

@extends('admin.global.body-list')

@section('toolbar-buttons')
    @include('list-toolbar')
@stop

@section('content')
    <form id="admin-form" action="" x-data="{ grid: $store.grid }"
        x-ref="gridForm"
        data-ordering="{{ $ordering }}"
        method="post">

        <x-filter-bar :form="$form" :open="$showFilters"></x-filter-bar>

        @if (count($items))
        {{-- RESPONSIVE TABLE DESC --}}
        <div class="d-block d-lg-none mb-3">
            @lang('unicorn.grid.responsive.table.desc')
        </div>

        <div class="grid-table table-lg-responsive">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    {{-- Toggle --}}
                    <th style="width: 1%">
                        <x-toggle-all></x-toggle-all>
                    </th>

                    {{-- State --}}
                    <th style="width: 5%" class="text-nowrap">
                        <x-sort field="language.state">
                            @lang('unicorn.field.state')
                        </x-sort>
                    </th>

                    {{-- FLAG --}}
                    <td style="width: 1%" class="text-nowrap">
                        <x-sort field="language.image">
                            @lang('unicorn.field.image')
                        </x-sort>
                    </td>

                    {{-- Title --}}
                    <th class="text-nowrap">
                        <x-sort field="language.title">
                            @lang('unicorn.field.title')
                        </x-sort>
                    </th>

                    {{-- Title --}}
                    <th class="text-nowrap">
                        <x-sort field="language.title_native">
                            @lang('unicorn.field.titlenative')
                        </x-sort>
                    </th>

                    <th style="width: 5%" class="text-nowrap">
                        <x-sort field="language.code">
                            @lang('unicorn.field.code')
                        </x-sort>
                    </th>

                    {{-- Ordering --}}
                    <th style="width: 10%" class="text-nowrap">
                        <div class="d-flex w-100 justify-content-end">
                            <x-sort
                                asc="language.ordering ASC"
                                desc="language.ordering DESC"
                            >
                                @lang('unicorn.field.ordering')
                            </x-sort>
                            @if($vm->reorderEnabled($ordering))
                                <x-save-order class="ml-2 ms-2"></x-save-order>
                            @endif
                        </div>
                    </th>

                    {{-- Delete --}}
                    <th style="width: 1%" class="text-nowrap">
                        @lang('unicorn.field.delete')
                    </th>

                    {{-- ID --}}
                    <th style="width: 1%" class="text-nowrap text-end">
                        <x-sort field="language.id">
                            @lang('unicorn.field.id')
                        </x-sort>
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach($items as $i => $item)
                    <?php
                        $entity = $vm->prepareItem($item);
                    ?>
                    <tr>
                        {{-- Checkbox --}}
                        <td>
                            <x-row-checkbox :row="$i" :id="$entity->getId()"></x-row-checkbox>
                        </td>

                        {{-- State --}}
                        <td>
                            <x-state-dropdown color-on="text"
                                button-style="width: 100%"
                                use-states
                                :workflow="$workflow"
                                :id="$entity->getId()"
                                :value="$item->state"
                            />
                        </td>

                        <td class="text-center">
                            <span class="{{ $localeService->getFlagIconClass($entity->getImage()) }}">

                            </span>
                        </td>

                        {{-- Title --}}
                        <td>
                            <div>
                                <a href="{{ $nav->to('language_edit')->id($entity->getId()) }}">
                                    {{ $entity->getTitle() }}
                                </a>
                            </div>
                            <div class="small text-muted">
                                {{ $entity->getAlias() }}
                            </div>
                        </td>

                        {{-- Title --}}
                        <td>
                            {{ $entity->getTitleNative() }}
                        </td>

                        {{-- Code --}}
                        <td>
                            {{ $entity->getCode() }}
                        </td>

                        {{-- Ordering --}}
                        <td class="text-end text-right">
                            <x-order-control
                                :enabled="$vm->reorderEnabled($ordering)"
                                :row="$i"
                                :id="$entity->getId()"
                                :value="$item->ordering"
                            ></x-order-control>
                        </td>

                        {{-- Delete --}}
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                @click="grid.deleteItem('{{ $entity->getId() }}')"
                                data-dos
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>

                        {{-- ID --}}
                        <td class="text-end">
                            {{ $entity->getId() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <td colspan="20">
                        {!! $pagination->render() !!}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
        @else
            <div class="grid-no-items card bg-light" style="padding: 125px 0;">
                <div class="card-body text-center">
                    <h3 class="text-secondary">@lang('unicorn.grid.no.items')</h3>
                </div>
            </div>
        @endif

        <div class="d-none">
            <input name="_method" type="hidden" value="PUT" />
            @csrf
        </div>

        <x-batch-modal :form="$form" namespace="batch"></x-batch-modal>
    </form>

@stop
