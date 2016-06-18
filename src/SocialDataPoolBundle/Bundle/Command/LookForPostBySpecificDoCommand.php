<?php

namespace SocialDataPoolBundle\Bundle\Command;

use SocialDataPool\Application\Service\Instagram\LookForInstagramPost;
use SocialDataPool\Application\Service\Instagram\LookForInstagramPostRequest;
use SocialDataPool\Application\Service\Uvinum\GetSpecificDo;
use SocialDataPool\Application\Service\Uvinum\GetSpecificDoRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LookForPostBySpecificDoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('instagram:search-specific-do')
            ->setDescription('Look for new instagram posts by the top selling products in Uvinum and save them in Redis.'
            )
            ->addArgument(
                'offset',
                InputArgument::REQUIRED,
                'Specific DO to search for'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    )
    {
        /** @var GetSpecificDo */
        $uvinum_use_case = $this->getContainer()->get('get_specific_do_use_case');
        /** @var LookForInstagramPost */
        $instagram_use_case = $this->getContainer()->get('look_for_instagram_post_use_case');
        $instagram_client   = $this->getContainer()->get('instagram_api_client');
        $token              = $this->getContainer()->getParameter('instagram_token');
        $instagram_client->setAccessToken($token);

        $offset = $input->getArgument('offset');

        $uvinum_request            = new GetSpecificDoRequest($offset);
        $specific_do_to_search_for = $uvinum_use_case->__invoke($uvinum_request);
        $specific_do_to_search_for = str_replace(' ', '', $specific_do_to_search_for);

        $request = new LookForInstagramPostRequest($specific_do_to_search_for
        );

        $instagram_use_case->__invoke($request);

        $output->writeln('Instagram Posts Processed');
    }
}
