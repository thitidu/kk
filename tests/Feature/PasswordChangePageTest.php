<?php

namespace Tests\Feature;

use Tests\TestCase;

class PasswordChangePageTest extends TestCase
{
    public function test_forgot_password_page_allows_password_change_without_an_email_link()
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('รหัสผ่านใหม่')
            ->assertSee('เปลี่ยนรหัสผ่าน')
            ->assertSee('คำเตือน')
            ->assertDontSee('ส่งลิงก์ตั้งรหัสผ่าน');
    }

    public function test_password_change_requires_all_fields_and_a_confirmed_new_password()
    {
        $this->from(route('password.request'))
            ->post(route('password.update'))
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors(['email', 'password']);
    }
}
