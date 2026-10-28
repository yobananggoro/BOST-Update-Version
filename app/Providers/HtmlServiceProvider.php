<?php

namespace App\Providers;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Collective\Html\HtmlBuilder;
use Collective\Html\FormBuilder;

class HtmlServiceProvider extends \Collective\Html\HtmlServiceProvider
{
    /**
     * Register any events for your application. 
     *
     * @return void
     */
    public function boot()
    {
        FormFacade::component('fgText', 'components.form.text', ['label', 'name', 'value', 'attributes' => [], 'help' => null, 'type' => 'text', 'layout' => false]);
        FormFacade::component('fgPassword', 'components.form.password', ['label', 'name', 'attributes' => [], 'help' => null, 'layout' => false]);
        FormFacade::component('fgSelect', 'components.form.select', ['label', 'name', 'options', 'value', 'attributes' => [], 'help' => null, 'layout' => false]);
        FormFacade::component('fgOption', 'components.form.option', ['label', 'name', 'options', 'value', 'help' => null, 'type' => 'radio', 'layout' => false]);
        FormFacade::component('fgFormButton', 'components.form.button', ['uri', 'action' => null, 'parameter' => null]);
        FormFacade::component('fgFormButton2', 'components.form.button2', ['uri', 'action' => null, 'parameter' => null]);
        FormFacade::component('fgFormButton3', 'components.form.button3', ['uri', 'action' => null, 'parameter' => null]);
        FormFacade::component('fgFormButton4', 'components.form.button_save_only', ['uri', 'action' => null, 'parameter' => null]);
        FormFacade::component('fgFilterButton', 'components.form.filter', []);
        FormFacade::component('fgFilterButton2', 'components.form.filter2', []);

        HtmlFacade::component('cardCollapse', 'components.html.card-collapse', []);
    }

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->singleton('html', function ($app) {
            return new HtmlBuilder($app['view'], $app['url']);
        });
    }
}
