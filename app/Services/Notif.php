<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class Notif
{
    /**
     * @var array
     */
    protected $notif = [];

    /**
     * @var array
     */
    // protected $routes = [];

    /**
     * @var array
     */
    // protected $uri_exceptions = ['home', 'login', 'logout'];

    /**
     * @var string
     */
    // protected $nav_format = '<i class="nav-icon %s"></i> %s';

    /**
     * @var string
     */
    // protected $item_format = '<li class="nav-item %s">%s</li>';

    /**
     * @var string
     */
    // protected $anchor_format = '<a href="%s" class="nav-link %s" %s>%s</a>';

    /**
     * @var string
     */
    // protected $child_format = '<ul class="nav nav-treeview">%s</ul>';

    /**
     * Navbar constructor.
     */
    public function __construct()
    {
        // $this->setAvailableRoutes();
        // $this->setUserNotif();
    }

    /**
     * @param array|null $navbar
     * @param int $level
     * @return string
     */
    public function render(array $notif = null): string
    {
        $notif = !is_null($notif) ? $notif : $this->notif;
        // dd($notif);
        // if(count($notif)>0){
        //     $count = count($notif);
        //         $search_1 = "PENGAJUAN";
        //         $search_2 = "REALISASI";
        //         $search_3 = "PENGEMBALIAN";
        //         $count_p = 0;
        //         $count_r = 0;
        //         $count_k = 0;
        //         foreach($notif as $key=> $value){
        //             foreach ($value as $va=>$v ) {
        //                 if(strstr($v,$search_1)){
        //                     $count_p = $count_p+1;
        //                 }
        //                 if(strstr($v,$search_2)){
        //                     $count_r = $count_r+1;
        //                 }
        //                 if(strstr($v,$search_3)){
        //                     $count_k = $count_k+1;
        //                 }
        //             }
        //         }
        // }else{
        //     $count = 0;
        //     $count_p = 0;
        //     $count_r = 0;
        //     $count_k = 0;
        // }
        // $link_1 = url('pengajuan-csr');
        // $link_2 = url('realisasi-csr');
        // $link_3 = url('pengembalian-csr');
        $html = '<li class="nav-item dropdown">
                    <a class="nav-link notific" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">'.@$count.'</span>
                    </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">'.@$count.' Pemberitahuan</span>
                <div class="dropdown-divider"></div>';
        foreach ($notif as $not) {
            $html .= '
              <a href="'.@$link_1.'" class="dropdown-item" id="notifAct1">
                <i class="fas fa-envelope mr-2"></i>  '.@$count_p.'
              </a>';
            // $html .= '
            //   <a href="'.@$link_2.'" class="dropdown-item" id="notifAct2">
            //     <i class="fas fa-money-bill-alt"></i>  '.@$count_r.' Request Approval Realisasi
            //   </a>';
            // $html .= '
            //   <a href="'.@$link_3.'" class="dropdown-item" id="notifAct3">
            //     <i class="fas fa-hand-holding-usd"></i>  '.@$count_k.' Request Approval Pengembalian
            //   </a>';
        }
        // $html .= '</li>';
        // $html='';
        return $html;
    }

    /**
     *
     */
    // protected function setAvailableRoutes()
    // {
    //     foreach (Route::getRoutes() as $route) {
    //         $uri = $route->uri();

    //         if ($route->methods()[0] === 'GET' && !in_array($uri, $this->uri_exceptions) && !Str::startsWith($uri, '/')) {
    //             $this->routes[$uri] = !empty($route->getName()) ? $route->getName() : $uri;
    //         }
    //     }
    // }

    /**
     *
     */
    protected function setUserNotif()
    {
        foreach (\Modules\Dashboard\Entities\Notification::where('receiver',auth()->user()->username)->where('is_read',null)->get() as $access) {
            if (($access->is_read == null)) {
                $structure = [
                    'id' => $access->id, 'notifikasi_category' => $access->notifikasi_category,
                    'message' => $access->message, 'is_read' => $access->is_read,
                    'receiver' => $access->receiver, 'sender' =>$access->sender
                ];
                
                $this->notif[] = $structure;
            }
        }
        // foreach (\Modules\Dashboard\Entities\Notification::where('branch_code',auth()->user()->app_unit_kerja->kode)
        //                                                   ->where('receiver',null)
        //                                                   ->where('role_name',null)
        //                                                   ->where('is_read',null)->get() as $access) {
        //   if (($access->is_read == null)) {
        //       $structure = [
        //           'id' => $access->id, 'notifikasi_category' => $access->notifikasi_category,
        //           'message' => $access->message, 'is_read' => $access->is_read,
        //           'receiver' => $access->receiver, 'sender' =>$access->sender
        //       ];
              
        //       $this->notif[] = $structure;
        //   }
      // }
    }

    /**
     * @return string
     */
    // protected function isChildActive($current, $parentId)
    // {
    //     // $access = \Modules\HakAkses\Entities\Role::findByName(auth()->user()->roles->first()->name)->modules->where('visible', 1);
    //     $access = \App\Entities\Module::where('visible', 1)->orderByRaw('cast(sequence as float)')->get();
    //     $mappedNav = $access->mapToGroups(function ($item, $key) {
    //         return [
    //             [
    //                 'id' => $item['id'],
    //                 'uri' => Str::contains($item['uri'], 'index') ? str_replace('.index', '', $item['uri']) : $item['uri'],
    //                 'parent_module' => $item['parent_module'],
    //             ]
    //         ];
    //     })[0]->firstWhere('uri', $current);
    //     $mappedParentId = isset($mappedNav['parent_module']) ? $mappedNav['parent_module'] : null;

    //     return !is_null($mappedParentId) && $mappedParentId === $parentId ? ' active' : '';
    // }
}
