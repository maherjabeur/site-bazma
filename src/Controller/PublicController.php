<?php

namespace App\Controller;

use App\Repository\CommunityOrganizationRepository;
use App\Repository\EventRepository;
use App\Repository\GalleryImageRepository;
use App\Repository\PageMediaRepository;
use App\Repository\PageRepository;
use App\Repository\SiteSettingRepository;
use App\Repository\SocialLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PublicController extends AbstractController
{
    #[Route('/healthz', name: 'app_healthz')]
    public function healthz(): Response
    {
        return new Response('ok', Response::HTTP_OK, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    #[Route('/', name: 'app_root')]
    public function root(): RedirectResponse
    {
        return $this->redirectToRoute('app_home', ['_locale' => 'ar']);
    }

    #[Route('/{_locale}', name: 'app_home', requirements: ['_locale' => 'ar|fr|en'])]
    public function home(Request $request, PageRepository $pages, GalleryImageRepository $images, EventRepository $events, SiteSettingRepository $settings, SocialLinkRepository $socialLinks, CommunityOrganizationRepository $organizations): Response
    {
        $locale = $request->getLocale();

        return $this->render('public/home.html.twig', [
            'locale' => $locale,
            'pages' => $pages->findPublished(),
            'images' => $images->findBy([], ['featured' => 'DESC', 'position' => 'ASC'], 8),
            'events' => $events->findBy(['published' => true], ['featured' => 'DESC', 'position' => 'ASC', 'eventDate' => 'DESC'], 4),
            'socialLinks' => $socialLinks->findBy(['featured' => true], ['position' => 'ASC'], 8),
            'organizations' => $organizations->findBy(['active' => true], ['position' => 'ASC']),
            'settings' => $settings,
        ]);
    }

    #[Route('/{_locale}/page/{slug}', name: 'app_page', requirements: ['_locale' => 'ar|fr|en'])]
    public function page(Request $request, string $slug, PageRepository $pages, PageMediaRepository $media): Response
    {
        $page = $pages->findOneBy(['slug' => $slug, 'published' => true]);
        if (!$page) {
            throw $this->createNotFoundException('Page introuvable');
        }

        return $this->render('public/page.html.twig', [
            'locale' => $request->getLocale(),
            'page' => $page,
            'media' => $media->findForPage($page),
        ]);
    }

    #[Route('/{_locale}/actualites/{slug}', name: 'app_news_show', requirements: ['_locale' => 'ar|fr|en'])]
    public function newsShow(Request $request, string $slug, EventRepository $events): Response
    {
        $event = $events->findOneBy(['slug' => $slug, 'published' => true]);
        if (!$event) {
            throw $this->createNotFoundException('Actualité introuvable');
        }

        return $this->render('public/news.html.twig', [
            'locale' => $request->getLocale(),
            'event' => $event,
        ]);
    }

    #[Route('/{_locale}/gallery', name: 'app_gallery', requirements: ['_locale' => 'ar|fr|en'])]
    public function gallery(Request $request, GalleryImageRepository $images): Response
    {
        return $this->render('public/gallery.html.twig', [
            'locale' => $request->getLocale(),
            'images' => $images->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/robots.txt', name: 'app_robots', format: 'txt')]
    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nSitemap: ".$this->generateUrl('app_sitemap', [], UrlGeneratorInterface::ABSOLUTE_URL)."\n";

        return new Response($content, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    #[Route('/sitemap.xml', name: 'app_sitemap', format: 'xml')]
    public function sitemap(PageRepository $pages, EventRepository $events): Response
    {
        $urls = [];
        foreach (['ar', 'fr', 'en'] as $locale) {
            $urls[] = $this->generateUrl('app_home', ['_locale' => $locale], UrlGeneratorInterface::ABSOLUTE_URL);
            $urls[] = $this->generateUrl('app_gallery', ['_locale' => $locale], UrlGeneratorInterface::ABSOLUTE_URL);
            foreach ($events->findBy(['published' => true]) as $event) {
                $urls[] = $this->generateUrl('app_news_show', ['_locale' => $locale, 'slug' => $event->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL);
            }
            foreach ($pages->findPublished() as $page) {
                $urls[] = $this->generateUrl('app_page', ['_locale' => $locale, 'slug' => $page->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL);
            }
        }

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        foreach (array_unique($urls) as $url) {
            $xml .= "  <url><loc>".htmlspecialchars($url, ENT_XML1)."</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>\n";
        }
        $xml .= "</urlset>\n";

        return new Response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
