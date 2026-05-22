<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    protected $helpers = ['form', 'url', 'auth'];
    protected array $siteData = [
        'name'         => 'Yayasan Bakti Mulya Masyarakat Mandiri',
        'shortName'    => 'YB3M Peduli',
        'tagline'      => 'Menguatkan bakti sosial, pendidikan, dan kemandirian umat melalui pengelolaan donasi yang amanah.',
        'address'      => 'Sekretariat Yayasan Bakti Mulya Masyarakat Mandiri, Indonesia.',
        'officeNote'   => 'Informasi operasional, program, dan penyaluran manfaat dikelola langsung oleh pengurus yayasan.',
        'email'        => 'admin@yb3mpeduli.org',
        'phone'        => '0853 5340 0700',
        'website'      => 'ybkb.org',
        'bankAccounts' => [
            ['bank' => 'BRI', 'number' => '6877-01-008170-53-3'],
            ['bank' => 'Mandiri', 'number' => '138-00-1874846-2'],
        ],
        'bankHolder'   => 'Yayasan Bakti Mulya Masyarakat Mandiri',
        'socials'      => [
            ['label' => 'Website', 'value' => 'ybkb.org', 'url' => 'https://ybkb.org'],
            ['label' => 'YouTube', 'value' => '@ybkbindonesia', 'url' => 'https://www.youtube.com/@ybkbindonesia'],
            ['label' => 'Instagram', 'value' => '@ybkbindonesia', 'url' => 'https://www.instagram.com/ybkbindonesia'],
        ],
    ];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    protected function basePageData(array $data = []): array
    {
        return array_merge([
            'site'       => $this->siteData,
            'currentUri' => service('request')->getUri()->getPath(),
            'authUser'   => auth_user(),
        ], $data);
    }
}
