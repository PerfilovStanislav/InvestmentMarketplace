<? $u = $this->user;
    foreach ($this->messages as $id => $m): ?>
    <div class="media flex">
        <div class="media-<?=($u['id'] && ($u['id']==$m['user_id']) || $u['session_id'] == $m['session_id'])?'right':'left'?>">
            <a href="widgets_panel.html#">
                <img class="media-object" alt="64x64" src="/assets/img/avatars/2.jpg">
            </a>
        </div>
        <div class="media-body">
            <span class="media-status"></span>
            <h5 class="media-heading"><?=$m['session_id'].' '.$id?>
                <small><?=$m['date_create']?></small>
            </h5><span><?=$m['message']?></span>
        </div>
    </div>
<? endforeach; ?>