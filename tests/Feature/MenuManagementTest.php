<?php

namespace Tests\Feature;

use Tests\TestCase;

class MenuManagementTest extends TestCase
{
    public function test_all_main_menu_pages_include_the_data_management_controls()
    {
        foreach (['news', 'teams.index', 'players.index', 'standings.index'] as $route) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('id="manageButton"', false)
                ->assertSee('id="adminModal"', false);
        }
    }
}
