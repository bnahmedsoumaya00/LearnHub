<?php
// src/Controller/CourseController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    /**
     * @Route("/courses", name="course_browse")
     */
    public function browse()
    {
        // Mock data for now — we'll connect to DB later
        $courses = [
            [
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn HTML, CSS, and JavaScript from scratch.',
                'instructor' => 'Dr. Karim Mansour',
                'status' => 'PUBLISHED',
            ],
            [
                'title' => 'Mobile App Design',
                'description' => 'Design beautiful Android and iOS apps with Figma.',
                'instructor' => 'Soumaya Ben Ahmed',
                'status' => 'PUBLISHED',
            ],
        ];

        return $this->render('course/browse.html.twig', [
            'courses' => $courses,
        ]);
    }
}