<?php

/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app       AppContext      Application context.
 * @var $vm        object          The view model object.
 * @var $uri       SystemUri       System Uri information.
 * @var $chronos   ChronosService  The chronos datetime service.
 * @var $nav       Navigator       Navigator object to build route.
 * @var $asset     AssetService    The Asset manage service.
 * @var $lang      LangService     The language translation service.
 */

declare(strict_types=1);

use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Asset\AssetService;
use Windwalker\Core\DateTime\ChronosService;
use Windwalker\Core\Language\LangService;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\Router\SystemUri;

/**
 * @var \Lyrasoft\Luna\Entity\Page $page
 * @var array            $rows
 */

$builder = $app->service(\Lyrasoft\Luna\PageBuilder\PageBuilder::class);
?>

@extends($page->getExtends())

@section('content')
    <div class="l-page-container">
        @if (is_array($rows))
            {!! $builder->renderPage($rows) !!}
        @endif
    </div>
@stop
