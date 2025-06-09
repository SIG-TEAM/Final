<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class PotensiFormPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/tambah-potensi';
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
                ->assertSee('Tambah Potensi Desa');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@type-select' => 'select[name=type]',
            '@nama-input' => 'input[name=nama]',
            '@kategori-select' => 'select[name=kategori_id]',
            '@deskripsi-textarea' => 'textarea[name=deskripsi]',
            '@alamat-input' => 'input[name=alamat]',
            '@kontak-input' => 'input[name=kontak]',
            '@lat-input' => 'input[name=latitude]',
            '@lng-input' => 'input[name=longitude]',
            '@geojson-input' => 'textarea[name=geojson]',
            '@photo-upload' => 'input[name=photo]',
            '@submit-button' => 'button[type=submit]',
            '@map-container' => 'div.leaflet-container',
        ];
    }

    /**
     * Fill potensi point form
     *
     * @param  Browser  $browser
     * @param  array  $data
     * @return void
     */
    public function fillPointForm(Browser $browser, array $data)
    {
        $browser->select('@type-select', 'point')
                ->type('@nama-input', $data['nama'])
                ->select('@kategori-select', $data['kategori_id'])
                ->type('@deskripsi-textarea', $data['deskripsi'])
                ->type('@alamat-input', $data['alamat'] ?? '')
                ->type('@kontak-input', $data['kontak'] ?? '')
                ->type('@lat-input', $data['latitude'])
                ->type('@lng-input', $data['longitude']);
                
        if (isset($data['photo'])) {
            $browser->attach('@photo-upload', $data['photo']);
        }
                
        $browser->press('@submit-button');
    }

    /**
     * Fill potensi area form
     *
     * @param  Browser  $browser
     * @param  array  $data
     * @return void
     */
    public function fillAreaForm(Browser $browser, array $data)
    {
        $browser->select('@type-select', 'area')
                ->type('@nama-input', $data['nama'])
                ->select('@kategori-select', $data['kategori_id'])
                ->type('@deskripsi-textarea', $data['deskripsi'])
                ->type('@alamat-input', $data['alamat'] ?? '')
                ->type('@kontak-input', $data['kontak'] ?? '')
                ->type('@geojson-input', $data['geojson']);
                
        if (isset($data['photo'])) {
            $browser->attach('@photo-upload', $data['photo']);
        }
                
        $browser->press('@submit-button');
    }
}
