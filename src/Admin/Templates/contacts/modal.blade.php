{{-- Part of Luna project. --}}
<?php
/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app           \Windwalker\Legacy\Web\Application                 Global Application
 * @var $package       \Windwalker\Legacy\Core\Package\AbstractPackage    Package object.
 * @var $view          \Luna\View\Contacts\ContactsHtmlView  View object.
 * @var $uri           \Windwalker\Legacy\Uri\UriData                     Uri information, example: $uri->path
 * @var $datetime      \Windwalker\Legacy\Core\DateTime\DateTime          PHP DateTime object of current time.
 * @var $helper        \Windwalker\Legacy\Core\View\Helper\Set\HelperSet  The Windwalker HelperSet object.
 * @var $router        \Windwalker\Legacy\Core\Router\MainRouter          Route builder object.
 * @var $asset         \Windwalker\Legacy\Core\Asset\AssetManager         The Asset manager.
 *
 * View variables
 * --------------------------------------------------------------
 * @var $filterBar     \Windwalker\Legacy\Core\Widget\Widget
 * @var $filterForm    \Windwalker\Legacy\Form\Form
 * @var $batchForm     \Windwalker\Legacy\Form\Form
 * @var $showFilterBar boolean
 * @var $grid          \Phoenix\View\Helper\GridHelper
 * @var $state         \Windwalker\Legacy\Structure\Structure
 * @var $items         \Windwalker\Legacy\Data\DataSet|\Luna\Record\ContactRecord[]
 * @var $item          \Luna\Record\ContactRecord
 * @var $i             integer
 * @var $pagination    \Windwalker\Legacy\Core\Pagination\Pagination
 */
?>

@extends('_global.luna.pure')

@section('toolbar')
    @include('toolbar')
@stop

@section('body')
    <div id="phoenix-admin" class="contacts-container grid-container">
        <form name="admin-form" id="admin-form" action="{{ $uri['full'] }}" method="POST" enctype="multipart/form-data">

            {{-- FILTER BAR --}}
            <div class="filter-bar">
                <button class="btn btn-default pull-right" onclick="parent.{{ $function }}('{{ $selector }}', '', '');">
                    <span class="glyphicon glyphicon-remove fa fa-remove fa-times"></span>
                    @translate('phoenix.grid.modal.button.cancel')
                </button>
                {!! $filterBar->render(array('form' => $form, 'show' => $showFilterBar)) !!}
            </div>

            {{-- RESPONSIVE TABLE DESC --}}
            <p class="visible-xs-block d-sm-block d-md-none">
                @translate('phoenix.grid.responsive.table.desc')
            </p>

            <div class="grid-table table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        {{-- TITLE --}}
                        <th>
                            {!! $grid->sortTitle('luna.contact.field.title', 'contact.title') !!}
                        </th>

                        {{-- STATE --}}
                        <th width="5%">
                            {!! $grid->sortTitle('luna.contact.field.state', 'contact.state') !!}
                        </th>

                        {{-- AUTHOR --}}
                        <th width="15%">
                            {!! $grid->sortTitle('luna.contact.field.author', 'contact.created_by') !!}
                        </th>

                        {{-- CREATED --}}
                        <th width="15%">
                            {!! $grid->sortTitle('luna.contact.field.created', 'contact.created') !!}
                        </th>

                        {{-- ID --}}
                        <th width="5%">
                            {!! $grid->sortTitle('luna.contact.field.id', 'contact.id') !!}
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($items as $i => $item)
                        <?php
                        $grid->setItem($item, $i);
                        ?>
                        <tr>
                            {{-- CHECKBOX --}}
                            <td>
                                <a href="#"
                                   onclick="parent.{{ $function }}('{{ $selector }}', '{{ $item->id }}', '{{ $item->title }}');">
                                    <span
                                        class="glyphicon glyphicon-menu-left fa fa-angle-right text-muted"></span> {{ $item->title }}
                                </a>
                            </td>

                            {{-- STATE --}}
                            <td class="text-center">
                                {!! $grid->published($item->state, array('only_icon' => true)) !!}
                            </td>

                            {{-- AUTHOR --}}
                            <td>
                                {{ property_exists($item, 'user_name') ? $item->user_name : $item->created_by }}
                            </td>

                            {{-- CREATED --}}
                            <td>
                                {{ \Windwalker\Legacy\Core\DateTime\Chronos::toLocalTime($item->created, 'Y-m-d') }}
                            </td>

                            {{-- ID --}}
                            <td>
                                {{ $item->id }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                    <tr>
                        {{-- PAGINATION --}}
                        <td colspan="25">
                            {!! $pagination->render() !!}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="hidden-inputs">
                {{-- METHOD --}}
                <input type="hidden" name="_method" value="PUT"/>

                {{-- TOKEN --}}
                {!! \Windwalker\Legacy\Core\Security\CsrfProtection::input() !!}
            </div>

            @include('_global.luna.widget.batch')
        </form>
    </div>
@stop
