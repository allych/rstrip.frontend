  <div id="blog" class=fl>

    <?php
        if (user::init()->has_error()){
          echo '<div class="error-box clearfix entry" id="error" style="padding: 15px 20px 15px; margin: 10px 0;">'.user::init()->get_error_message().'</div>';
        }
    ?>
    <form action="/authorization/authorize" method="post" id="contact_form">
      <div class="name">
        <label>Логин:</label>
        <input type="text" name="login" value="<?php if (post::passed('login')){ echo post::get_as_is('login'); } ?>" />
      </div>
      <div class="email">
        <label>Пароль:</label>
        <input type="password" name="password" />
      </div>
      <div id="loader">
        <input type="submit" value="Войти">
      </div>
    </form>
  </div>
