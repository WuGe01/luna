<?php

/**
 * Global variables
 * --------------------------------------------------------------
 * @var  $app       AppContext      Application context.
 * @var  $vm        MenuListView The view model object.
 * @var  $uri       SystemUri       System Uri information.
 * @var  $chronos   ChronosService  The chronos datetime service.
 * @var  $nav       Navigator       Navigator object to build route.
 * @var  $asset     AssetService    The Asset manage service.
 * @var  $lang      LangService     The language translation service.
 */

declare(strict_types=1);

use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Asset\AssetService;
use Windwalker\Core\DateTime\ChronosService;
use Windwalker\Core\Language\LangService;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\Router\SystemUri;
use Lyrasoft\Luna\Module\Admin\Menu\MenuListView;

$level = $level ?? 2;
$dropdown = $dropdown ?? false;
$vertical = $vertical ?? false;

/**
 * @var \Lyrasoft\Luna\Menu\Tree\MenuNodeInterface $parent
 * @var \Lyrasoft\Luna\Menu\Tree\MenuNodeInterface $item
 */
?>

@foreach ($parent->getChildren() as $item)
    @if ($item->isHidden())
        @continue
    @endif

    @if ($item instanceof \Lyrasoft\Luna\Menu\Tree\DbMenuNode && $item->getViewInstance() instanceof \Lyrasoft\Luna\Menu\LayoutRenderedMenuInterface)
        @include($item->getViewInstance()->getLayout())
    @elseif ($level > 1 && $item instanceof \Lyrasoft\Luna\Menu\Tree\MenuNode)
        @include('@menu::' . $item->getLayout())
    @else
        @include('@menu::link.link')
    @endif
@endforeach
