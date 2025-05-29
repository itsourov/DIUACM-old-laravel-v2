<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // How DIU ACM Works section data
        $steps = [
            [
                'number' => 1,
                'title' => 'Master the Green Sheet',
                'description' => 'Complete our curated set of beginner-level problems. Aim for 60% completion to become eligible for the Blue Sheet.',
                'icon' => 'book-open',
            ],
            [
                'number' => 2,
                'title' => 'Join Regular Contests',
                'description' => 'Participate in our weekly onsite DIU Individual Contest every Friday and track your progress through our Individual Contest Tracker.',
                'icon' => 'code-xml',
            ],
            [
                'number' => 3,
                'title' => 'Visit ACM Lab',
                'description' => 'Come to KT-310 to meet the community and get help with your competitive programming journey.',
                'icon' => 'users',
            ],
        ];

        // Learning Programs section data
        $learningPrograms = [
            [
                'title' => 'Green Sheet Program',
                'description' => 'Master programming basics with our curated problem set covering fundamental concepts. Solve 60% to qualify for Blue Sheet.',
                'icon' => 'file-code2',
                'link' => '/blog/green-sheet',
            ],
            [
                'title' => 'Blue Sheet Advanced',
                'description' => '1000+ carefully selected problems for advanced programmers. Regular updates based on top solver performance.',
                'icon' => 'award',
                'link' => '/blog/blue-sheet',
            ],
            [
                'title' => 'ACM Advanced Camp',
                'description' => 'Intensive training program for TOPC top performers with mentoring from seniors and alumni.',
                'icon' => 'target',
                'link' => '/blog/advanced-camp',
            ],
        ];

        // Stats section data
        $stats = [
            [
                'value' => '100+',
                'label' => 'Weekly Problems',
                'icon' => 'code-xml',
                'color' => 'blue',
            ],
            [
                'value' => '20+',
                'label' => 'Annual Contests',
                'icon' => 'trophy',
                'color' => 'cyan',
            ],
            [
                'value' => '50+',
                'label' => 'ICPC Participants',
                'icon' => 'award',
                'color' => 'violet',
            ],
            [
                'value' => '200+',
                'label' => 'Active Members',
                'icon' => 'users',
                'color' => 'emerald',
            ],
        ];

        // Competitions section data
        $competitions = [
            [
                'title' => 'Take-Off Programming Contest',
                'description' => 'Semester-based contest series for beginners with mock, preliminary, and main rounds.',
                'phases' => ['Mock Round', 'Preliminary', 'Main Contest'],
                'eligibility' => '1st semester students enrolled in Programming & Problem Solving',
            ],
            [
                'title' => 'Unlock The Algorithm',
                'description' => 'Advanced algorithmic contest focusing on data structures and algorithms.',
                'phases' => ['Mock Round', 'Preliminary', 'Final Round'],
                'eligibility' => 'Students enrolled in Algorithms course',
            ],
            [
                'title' => 'DIU ACM Cup',
                'description' => 'Tournament-style competition to crown the best programmer each semester.',
                'phases' => ['Group Stage', 'Knockouts', 'Finals'],
                'eligibility' => 'Top 32 regular programmers',
            ],
        ];

        // Benefits section data
        $benefits = [
            [
                'title' => 'Structured Learning',
                'description' => 'Follow our carefully designed learning tracks to build skills progressively from basics to advanced topics.',
                'icon' => 'book-open',
            ],
            [
                'title' => 'Regular Contests',
                'description' => "Weekly contests help you apply what you've learned and track your improvement over time.",
                'icon' => 'trophy',
            ],
            [
                'title' => 'Expert Mentorship',
                'description' => 'Get guidance from experienced seniors and alumni who have excelled in competitive programming.',
                'icon' => 'users',
            ],
        ];

        // Rules section data
        $rules = [
            [
                'title' => 'Contest Rules',
                'icon' => 'trophy',
                'items' => [
                    'No external website usage during contests except the platform',
                    'Hard copy templates are allowed with specified limits',
                    'Code sharing must be enabled on Vjudge contests',
                    'Any form of plagiarism results in permanent ban',
                ],
            ],
            [
                'title' => 'Lab Rules',
                'icon' => 'laptop',
                'items' => [
                    'Lab access requires regular ACM programmer status',
                    'Maintain respectful behavior towards seniors and teachers',
                    'Avoid disturbing others during practice sessions',
                    'Keep the lab clean and organized',
                ],
            ],
            [
                'title' => 'Online Contest Rules',
                'icon' => 'globe',
                'items' => [
                    'Forum usage prohibited during online contests',
                    'Basic resource websites (GFG, CPAlgo) are allowed',
                    'Maintain code submission history',
                    'Report technical issues immediately',
                ],
            ],
        ];

        return view('homepage', compact(
            'steps',
            'learningPrograms',
            'stats',
            'competitions',
            'benefits',
            'rules'
        ));
    }
}
