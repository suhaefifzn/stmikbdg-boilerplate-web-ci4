<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

// ? Service
use App\Models\AuthService;

class HasToken implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();

        // terdapat sesi token
        if ($session->has('token')) {
            $authService = new AuthService();
            $token = $session->get('token');
            $checkToken = $authService->checkToken($token);
            $statusToken = json_decode($checkToken->getBody())->status;
            $siteAccess = $authService->validateUserSiteAccess(base_url());
            $statusSiteAccess = json_decode($siteAccess->getBody())->status;

            if ($statusToken !== 'success') {
                return redirect()->to(getenv('LOGIN_BASE_URL') . '/verify?site=' . base_url());
            }

            if ($statusSiteAccess === 'fail') {
                return redirect('logout');
            }
        }

        // tidak ada sesi token
        if (!$session->has('token')) {
            return redirect('logout');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
