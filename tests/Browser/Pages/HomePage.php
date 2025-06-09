<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url())
                ->waitFor('div.leaflet-container', 10); // Wait for map to load
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@map-container' => 'div.leaflet-container',
            '@map-marker' => 'div.leaflet-marker-icon',
            '@map-area' => 'path.leaflet-interactive',
            '@category-filter' => '.category-filter',
            '@apply-filter-button' => 'button.apply-filter',
            '@show-points-only' => '#show-points-only',
            '@show-areas-only' => '#show-areas-only',
            '@show-all' => '#show-all',
        ];
    }

    /**
     * Filter by category
     *
     * @param  Browser  $browser
     * @param  string   $category
     * @return void
     */
    public function filterByCategory(Browser $browser, $category)
    {
        $browser->click('@category-filter')
                ->check("input[value=\"$category\"]")
                ->click('@apply-filter-button')
                ->waitFor('@map-container', 10);
    }

    /**
     * Click on a map marker
     *
     * @param  Browser  $browser
     * @return void
     */
    public function clickMapMarker(Browser $browser)
    {
        $browser->click('@map-marker')
                ->waitFor('.potensi-detail-popup', 10);
    }

    /**
     * Click on a map area
     *
     * @param  Browser  $browser
     * @return void
     */
    public function clickMapArea(Browser $browser)
    {
        $browser->click('@map-area')
                ->waitFor('.potensi-detail-popup', 10);
    }

    /**
     * Toggle to show only points
     *
     * @param  Browser  $browser
     * @return void
     */
    public function showPointsOnly(Browser $browser)
    {
        $browser->click('@show-points-only')
                ->assertPresent('@map-marker')
                ->pause(1000) // Wait for transition
                ->assertMissing('@map-area');
    }

    /**
     * Toggle to show only areas
     *
     * @param  Browser  $browser
     * @return void
     */
    public function showAreasOnly(Browser $browser)
    {
        $browser->click('@show-areas-only')
                ->assertPresent('@map-area')
                ->pause(1000) // Wait for transition
                ->assertMissing('@map-marker');
    }
}
