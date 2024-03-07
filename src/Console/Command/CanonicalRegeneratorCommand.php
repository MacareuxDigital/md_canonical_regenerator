<?php
/**
 * @author: Biplob Hossain <biplob.ice@gmail.com>
 */

namespace Macareux\CanonicalRegenerator\Console\Command;

use Concrete\Core\Console\Command;
use Concrete\Core\Page\Page;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CanonicalRegeneratorCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('md:canonical:regenerate')
            ->setDescription('Regenerate canonical URLs under a specific path')
            ->setAliases(['md:regenerate:canonical, md:canonical-regenerate, md:regenerate-canonical'])
            ->addOption('page-path', 'p', InputOption::VALUE_REQUIRED, 'Page path under which canonical URLs should be regenerated')
            ->addEnvOption();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        // Get the page path from the command line
        $pagePath = $input->getOption('page-path');

        // If no page path is provided, or it's '/', get the home page
        if (empty($pagePath) || $pagePath === '/') {
            $parentPage = Page::getByID(Page::getHomePageID());
        } else {
            $parentPage = Page::getByPath($pagePath);
        }

        // Check if the parent page is found and not in trash
        if ($parentPage === null || $parentPage->isError() || $parentPage->isInTrash()) {
            $output->writeln('<error>Error: Parent page not found or in trash.</error>');

            return 1;
        }

        $this->output->writeln('Regenerating canonical URLs under ' . $parentPage->getCollectionPath() . '...');

        // Regenerate canonical URLs for the parent page and its children
        $this->regenerateChildPageCanonicalUrls($parentPage);

        $this->output->writeln('<info>Canonical URLs regenerated successfully!</info>');

        return 0;
    }

    protected function regenerateChildPageCanonicalUrls(Page $parentPage): void
    {
        // Get the child pages of the parent
        $childPages = $parentPage->getCollectionChildren();

        foreach ($childPages as $childPage) {
            // Generate the new canonical path for the child page
            $newCanonicalPath = $this->generateCanonicalPath($parentPage, $childPage);

            // Set the new canonical path for the child page
            $childPage->setCanonicalPagePath($newCanonicalPath);

            // Recursively update canonical paths for all descendants
            $this->regenerateChildPageCanonicalUrls($childPage);
        }
    }

    protected function generateCanonicalPath(Page $parentPage, Page $childPage): string
    {
        // Get the paths of the parent and child pages
        $parentPath = $parentPage->getCollectionPath();
        $childPath = $childPage->getCollectionPath();

        // Remove the parent path from the child path
        $relativeChildPath = substr($childPath, strlen($parentPath));

        // Concatenate the parent path and relative child path
        $newCanonicalPath = rtrim($parentPath, '/') . '/' . ltrim($relativeChildPath, '/');

        // Output the current operation
        $this->output->writeln('Updating Canonical URL for ' . $childPage->getCollectionPath() . ' to ' . $newCanonicalPath);

        return $newCanonicalPath;
    }
}
