<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class BaseComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('curTheme', theme());
        $view->with('adminUnreadNotices',allNotices(admin()->id,true));
    }
}
