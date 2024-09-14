<?php

/**
 * @var \Core\Render $render
 * @var array<\Source\Models\User> $users
 * @var array<\Source\Models\Role> $roles
 */
?>
<?php $render->component('dashboard_header'); ?>

<div class="posts-bottom-section">
    <div class="posts-sorting-and-search">
        <div class="posts-search-container">
            <input type="text" placeholder="Поиск по странице" class="posts-search-input">
        </div>
        <select name="post-sorting" id="post-sorting">
            <option value="1">Сначала новые</option>
            <option value="2">Сначала старые</option>
        </select>
    </div>
    <div class="posts-post-grid">
        <div class="posts-add-new-post-block">
            <p class="posts-count">Всего записей: <span class="posts-counter">8</span></p>
            <a href="\admin\post\create" class="posts-create-new-post-button">
                <img src="/assets/themes/Basic/img/create-new-post.svg" alt="" id="posts-create-new-post-icon"> Создать новую запись
            </a>
        </div>

        <div class="posts-post-grid-block">
            <div class="posts-post-card-block">
                <div class="posts-post-card">
                    <img src="/assets/themes/Basic/img/post-thumb.png" alt="" class="posts-card-post-thumb">
                    <div class="posts-post-card-content-block">
                        <p class="posts-post-card-author"><img src="/assets/themes/Basic/img/post-card-author-icon.svg" alt="" id="post-author"> Oreele</p>
                        <p class="posts-post-content">FeathersJS: Быстрая навигация в мире Node.js и MongoDB</p>
                        <p class="posts-post-pub-date">
                            <img src="/assets/themes/Basic/img/post-card-date-icon.svg" alt="" id="post-date"> 09.08.23
                        </p>
                    </div>
                </div>
                <div class="posts-post-action-buttons">
                    <ul class="posts-post-action-buttons-list">
                        <li class="posts-action-button"><img src="/assets/themes/Basic/img/watch-post-icon.svg" alt="" class="posts-action-button-icon"></li>
                        <li class="posts-action-button"><img src="/assets/themes/Basic/img/edit-post-icon.svg" alt="" class="posts-action-button-icon"></li>
                        <li class="posts-action-button"><img src="/assets/themes/Basic/img/delete-post-icon.svg" alt="" class="posts-action-button-icon"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php $render->component('dashboard_footer'); ?>