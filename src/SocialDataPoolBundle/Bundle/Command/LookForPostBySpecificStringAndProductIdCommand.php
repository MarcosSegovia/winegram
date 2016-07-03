<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Instagram\LookForInstagramPostRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookForPostBySpecificStringAndProductIdCommand extends ContainerAwareCommand
{
    const SEARCH_ID = 1;

    protected function configure()
    {
        $this
            ->setName('instagram:search-string-product')
            ->setDescription('Look for new instagram posts by its name, associate a product id and save them in Redis.'
            )
            ->addArgument(
                'query',
                InputArgument::REQUIRED,
                'The string you want to search for'
            )
            ->addArgument(
                'product_id',
                InputArgument::REQUIRED,
                'Specific product id from Uvinum'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        $instagram_use_case = $this->getContainer()->get('look_for_instagram_post_use_case');
        $instagram_client   = $this->getContainer()->get('instagram_api_client');
        $token              = $this->getContainer()->getParameter('instagram_token');
        $instagram_client->setAccessToken($token);

        $query      = $input->getArgument('query');
        $product_id = $input->getArgument('product_id');

        $output->writeln('Searching Instagram posts with tag: ' . $query);

        $request = new LookForInstagramPostRequest($query, self::SEARCH_ID,
            $product_id
        );
        $instagram_use_case->__invoke($request);

        $output->writeln('Instagram Posts Processed');
    }
}
