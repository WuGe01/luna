<?php

/**
 * Global variables
 * --------------------------------------------------------------
 * @var  $app       AppContext      Application context.
 * @var  $vm        PageListView  The view model object.
 * @var  $uri       SystemUri       System Uri information.
 * @var  $chronos   ChronosService  The chronos datetime service.
 * @var  $nav       Navigator       Navigator object to build route.
 * @var  $asset     AssetService    The Asset manage service.
 * @var  $lang      LangService     The language translation service.
 */

declare(strict_types=1);

use Lyrasoft\Luna\Module\Admin\Page\PageListView;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Asset\AssetService;
use Windwalker\Core\DateTime\ChronosService;
use Windwalker\Core\Language\LangService;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\Router\SystemUri;

?>

<div x-title="toolbar" x-data="{ form: $store.grid.form, grid: $store.grid }">
    <button type="button" class="btn btn-primary btn-sm"
        @click="form.post('{{ $nav->to('page_create') }}')"
        style="min-width: 150px"
    >
        <i class="fa fa-plus"></i>
        @lang('unicorn.toolbar.new')
    </button>
    <button type="button" class="btn btn-info btn-sm"
        @click="grid.form.post()"
    >
        <i class="fa fa-clone"></i>
        @lang('unicorn.toolbar.duplicate')
    </button>
    <x-state-dropdown color-on="text"
        button-style="width: 100%"
        use-states
        batch
        :workflow="[$workflow]"
    >
        @lang('unicorn.toolbar.state.change')
    </x-state-dropdown>
    <button type="button" class="btn btn-dark btn-sm"
        @click="grid.validateChecked(null, function () {
            (new bootstrap.Modal('#batch-modal')).show();
        })"
    >
        <i class="fa fa-sliders"></i>
        @lang('unicorn.toolbar.batch')
    </button>
    <button type="button" class="btn btn-outline-danger btn-sm"
        @click="grid.deleteList()"
    >
        <i class="fa fa-trash"></i>
        @lang('unicorn.toolbar.delete')
    </button>
</div>
<script>
import ButtonRadio from '../../../../../assets/src/vue/components/page-builder/form/ButtonRadio';
export default {
    components: { ButtonRadio }
};
</script>
