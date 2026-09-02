<?php

namespace App\MessageHandler;

use App\Entity\GamePriceHistory;
use App\Entity\VideoGame;
use App\Message\UpdateVideoGamePrice;
use App\Service\Ollama\OllamaPriceEstimator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateVideoGamePriceHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private OllamaPriceEstimator $priceEstimator,
    ) {
    }

    public function __invoke(UpdateVideoGamePrice $message): void
    {
        $videoGame = $this->entityManager->find(VideoGame::class, $message->videoGameId);

        if (!$videoGame) {
            return;
        }

        $price = $this->priceEstimator->estimate(
            (string) $videoGame->getName(),
            array_values($videoGame->getConsoles()->map(
                static fn ($console): string => (string) $console->getName(),
            )->toArray()),
        );
        $today = new \DateTimeImmutable('today');
        $historyRepository = $this->entityManager->getRepository(GamePriceHistory::class);
        $history = $historyRepository->findOneBy([
            'game' => $videoGame,
            'date' => $today,
        ]) ?? new GamePriceHistory();

        $videoGame->setPrice($price);
        $history
            ->setGame($videoGame)
            ->setPrice($price)
            ->setDate($today);

        $this->entityManager->persist($history);
        $this->entityManager->flush();
    }
}
