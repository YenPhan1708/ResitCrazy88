<?php

function getActualTeamScores(string $dataPath): array {
    if (!file_exists($dataPath)) {
        return [];
    }

    $json = file_get_contents($dataPath);
    $data = json_decode($json, true);
    $teams = [];

    if (!isset($data['groups'])) {
        return [];
    }

    foreach ($data['groups'] as $group) {
        $teams[] = [
            'team' => $group['name'] ?? 'Unnamed Team',
            'score' => $group['score'] ?? 0
        ];
    }

    return $teams;
}

function renderRanking(array $teams) {
    if (empty($teams)) {
        echo '<p class="no-results">No teams to rank yet.</p>';
        return;
    }

    // Sort by descending score
    usort($teams, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    $topThree = array_slice($teams, 0, 3);
    $rest = array_slice($teams, 3);
    $maxScore = $topThree[0]['score'] ?? 1;

    // Prepare correct order for display: 2nd, 1st, 3rd
    $visualOrder = [];
    if (isset($topThree[1])) $visualOrder[] = ['team' => $topThree[1], 'class' => 'second', 'label' => '2nd'];
    if (isset($topThree[0])) $visualOrder[] = ['team' => $topThree[0], 'class' => 'first',  'label' => '1st'];
    if (isset($topThree[2])) $visualOrder[] = ['team' => $topThree[2], 'class' => 'third',  'label' => '3rd'];

    echo '<div class="top-three">';
    foreach ($visualOrder as $item) {
        $player = $item['team'];
        $heightPercent = round(($player['score'] / $maxScore) * 100);

        echo '
        <div class="position ' . $item['class'] . '">
            <div class="bar-wrapper">
                <div class="bar">
                    <div class="bar-fill" style="height: ' . $heightPercent . '%;"></div>
                    <div class="bar-content">
                        <div class="label">' . $item['label'] . '</div>
                        <div class="team-name">' . htmlspecialchars($player['team']) . '</div>
                        <div class="points">' . intval($player['score']) . ' Pts</div>
                    </div>
                </div>
            </div>
        </div>';
    }
    echo '</div>';

    if (!empty($rest)) {
        echo '<ul class="ranking-list">';
        $rank = 4;
        foreach ($rest as $team) {
            echo '<li><span class="rank">' . $rank++ . '.</span> '
                . '<span class="team-name">' . htmlspecialchars($team['team']) . '</span>'
                . '<span class="points">' . intval($team['score']) . ' Pts</span></li>';
        }
        echo '</ul>';
    }
}
