{{-- Part of earth project. --}}
<?php
/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app      \Windwalker\Legacy\Web\Application                 Global Application
 * @var $package  \Lyrasoft\Luna\LunaPackage                   Package object.
 * @var $view     \Windwalker\Legacy\Data\Data                       Some information of this view.
 * @var $uri      \Windwalker\Legacy\Uri\UriData                     Uri information, example: $uri->path
 * @var $chronos  \Windwalker\Legacy\Core\DateTime\Chronos           PHP DateTime object of current time.
 * @var $helper   \Windwalker\Legacy\Core\View\Helper\Set\HelperSet  The Windwalker HelperSet object.
 * @var $router   \Windwalker\Legacy\Core\Router\PackageRouter       Router object.
 * @var $asset    \Windwalker\Legacy\Core\Asset\AssetManager         The Asset manager.
 *
 * View variables
 * --------------------------------------------------------------
 * @var $addon      \Lyrasoft\Luna\PageBuilder\AbstractAddon
 * @var $classes    array
 * @var $attrs      array
 * @var $content    \Windwalker\Legacy\Structure\Structure
 * @var $options    \Windwalker\Legacy\Structure\Structure
 * @var $addonRenderer \Lyrasoft\Luna\PageBuilder\Renderer\AddonRenderer
 */
?>
<div id="{{ $options['html_id'] }}" class="c-addon c-addon--{{ $content['type'] }} {{ implode(' ', $classes) }}"
    {!! \Windwalker\Legacy\Dom\Builder\HtmlBuilder::buildAttributes($attrs) !!}>
    @if ($options['background.overlay'])
        <div class="l-bg-overlay"></div>
    @endif
    <div class="l-bg-content c-addon__body">
        @yield('body', 'Addon Body')
    </div>
</div>
