<div class="scroll-sidebar">
  <nav class="sidebar-nav">
    <ul id="sidebarnav">
      <li @if(isset($menu) && $menu == 'home') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/index" aria-expanded="false">
          <i class="mdi mdi-gauge"></i><span class="hide-menu">Действия </span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'menu') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/menu" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Меню </span>
        </a>
      </li>
      <li class="treeview @if(isset($menu) && $menu == 'order') active @endif">
        <a href="/admin/order?active=1">
          <i class="fa fa-list"></i>
          <? $count = \App\Models\Order::where('is_show','=','1')->where('magazine_id','>',0)->count();?>

          <span>Заявки на журнал</span>

          <span class="label label-primary pull-right notice-icon" @if($count > 0) style="display: block" @endif id="review_count">{{$count}}</span>
        </a>
      </li>
      <li class="treeview @if(isset($menu) && $menu == 'order-seminar') active @endif">
        <a href="/admin/order/seminar?active=1">
          <i class="fa fa-list"></i>
          <? $count = \App\Models\Order::where('is_show','=','1')->where('seminar_id','>',0)->count();?>

          <span>Заявки на семинар</span>

          <span class="label label-primary pull-right notice-icon" @if($count > 0) style="display: block" @endif id="review_count2">{{$count}}</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'magazine') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/magazine" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Журналы</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'publication') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/publication" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Статьи</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'category') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/category" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Категория статьи</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'seminar') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/seminar" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Семинары</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'slider') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/slider" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Слайдер</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'info') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/info" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Статичные тексты</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'gallery') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/gallery" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Галерея</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'document') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/document" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Документы</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'video') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/video" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Видеогалерея</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'certificate') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/certificate" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Свидетельство </span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'partner') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/partner" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Партнеры</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'member') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/member" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Члены ассоциации</span>
        </a>
      </li>

      <li @if(isset($menu) && $menu == 'news') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/news" aria-expanded="false">
          <i class="mdi mdi-bank"></i><span class="hide-menu">Новости</span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'user') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/user" aria-expanded="false">
          <i class="mdi mdi-account"></i><span class="hide-menu">Администраторы </span>
        </a>
      </li>
      <li @if(isset($menu) && $menu == 'password') class="active"  @endif>
        <a class="waves-effect waves-dark" href="/admin/password" aria-expanded="false">
          <i class="mdi mdi-settings"></i><span class="hide-menu">Сменить пароль </span>
        </a>
      </li>
      <li>
        <a class="waves-effect waves-dark" href="/admin/logout" aria-expanded="false">
          <i class="mdi mdi-settings"></i><span class="hide-menu">Выйти</span>
        </a>
      </li>
    </ul>
  </nav>
</div>