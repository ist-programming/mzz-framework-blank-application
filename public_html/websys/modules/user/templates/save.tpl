<div class="jipTitle">{if $isEdit}Редактирование пользователя{else}Создание пользователя{/if}</div>
{form action=$form_action method="post" jip=true}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        {if $isEdit}
            <tr>
                <td>Идентификатор:</td>
                <td><strong>{$user->getId()}</strong></td>
            </tr>
        {/if}
        <tr>
            <td style="width: 30%;">{form->caption name="user[login]" value="Логин"}</td>
            <td style="width: 70%;">{form->text name="user[login]" value=$user->getLogin() size="40"} {$validator->getFieldError('user[login]')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="user[password]" value="Пароль"}</td>
            <td style="width: 70%;">{form->password name="user[password]" size="40"} {$validator->getFieldError('user[password]')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="user[name]" value="Имя"}</td>
            <td style="width: 70%;">{form->text name="user[name]" size="40" value=$user->getName()} {$validator->getFieldError('user[name]')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="user[email]" value="Email"}</td>
            <td style="width: 70%;">{form->text name="user[email]" size="40" value=$user->getEmail()} {$validator->getFieldError('user[email]')}</td>
        </tr>
        <tr>
            <td style="width: 30%;">{form->caption name="user[confirmed]" value="Активен"}</td>
            <td style="width: 70%;">{form->checkbox name="user[confirmed]" size="40" value=$user->isConfirmed()} {$validator->getFieldError('user[confirmed]')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
