{{-- Part of Luna project. --}}
<?php
/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app      \Windwalker\Legacy\Web\Application                 Global Application
 * @var $package  \Lyrasoft\Luna\LunaPackage                 Package object.
 * @var $view     \Lyrasoft\Luna\View\Pages\PagesHtmlView  View object.
 * @var $uri      \Windwalker\Legacy\Uri\UriData                     Uri information, example: $uri->path
 * @var $chronos  \Windwalker\Legacy\Core\DateTime\DateTime          PHP DateTime object of current time.
 * @var $helper   \Windwalker\Legacy\Core\View\Helper\Set\HelperSet  The Windwalker HelperSet object.
 * @var $router   \Windwalker\Legacy\Core\Router\MainRouter          Route builder object.
 * @var $asset    \Windwalker\Legacy\Core\Asset\AssetManager         The Asset manager.
 */
?>

<button class="btn btn-primary btn-sm btn-wide phoenix-btn-new"
    onclick="Phoenix.post('{{ $router->route('page', ['new' => true]) }}', { new: 1 })">
    <span class="fa fa-plus"></span>
    @lang('phoenix.toolbar.new')
</button>

<button type="button" class="btn btn-info btn-sm phoenix-btn-duplicate"
    onclick="Phoenix.Grid.hasChecked();Phoenix.post();">
    <span class="fa fa-copy"></span>
    @lang('phoenix.toolbar.duplicate')
</button>

<div class="dropdown btn-group phoenix-btn-state-dropdown">
    <button class="btn btn-default btn-secondary btn-sm dropdown-toggle" type="button" id="state-dropdown-toggle"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @lang('phoenix.toolbar.state.change')
    </button>

    <ul class="dropdown-menu">
        <li>
            <a href="javascript://" class="dropdown-item phoenix-btn-publish"
                onclick="Phoenix.Grid.hasChecked().batch('publish');">
                <span class="fa fa-fw fa-check text-success"></span>
                @lang('phoenix.toolbar.publish')
            </a>

            <a href="javascript://" class="dropdown-item phoenix-btn-unpublish"
                onclick="Phoenix.Grid.hasChecked().batch('unpublish');">
                <span class="fa fa-fw fa-remove fa-times text-danger"></span>
                @lang('phoenix.toolbar.unpublish')
            </a>
        </li>
    </ul>
</div>

{{--<button type="button" class="btn btn-default btn-dark btn-sm phoenix-btn-batch" data-toggle="modal"--}}
    {{--data-target="#batch-modal" onclick="Phoenix.Grid.hasChecked(null, event);">--}}
    {{--<span class="fa fa-sliders fa-sliders-h"></span>--}}
    {{--@lang('phoenix.toolbar.batch')--}}
{{--</button>--}}

<button type="button" class="btn btn-default btn-outline-danger btn-sm phoenix-btn-delete"
    onclick="Phoenix.Grid.hasChecked().deleteList();">
    <span class="fa fa-trash"></span>
    @lang('phoenix.toolbar.delete')
</button>
