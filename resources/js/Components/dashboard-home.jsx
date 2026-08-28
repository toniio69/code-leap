import React from 'react';
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from "@/components/ui/card";
import { Progress } from "@/components/ui/progress";
import { Button } from "@/components/ui/button";
import { Badge } from "@/components/ui/badge";
import { BookOpen, PlayCircle } from "lucide-react";

export default function DashboardHome({ courses = [] }) {
  return (
    <div className="p-8 space-y-6 max-w-7xl mx-auto">
      <div className="flex justify-between items-center">
        <div>
          <h1 className="text-3xl font-bold tracking-tight">My Learning</h1>
          <p className="text-muted-foreground">Track your ongoing courses and platform activities.</p>
        </div>
        <Button>Explore Courses</Button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {courses.map((course) => (
          <Card key={course.id} className="flex flex-col justify-between">
            <CardHeader>
              <div className="flex justify-between items-start">
                <Badge variant="outline">{course.category || 'Programming'}</Badge>
                <span className="text-xs text-muted-foreground flex items-center gap-1">
                  <BookOpen className="h-3 w-3" /> {course.lessons_count || 12} Lessons
                </span>
              </div>
              <CardTitle className="line-clamp-1 mt-2">{course.title}</CardTitle>
              <CardDescription className="line-clamp-2">{course.description}</CardDescription>
            </CardHeader>
            
            <CardContent className="space-y-2">
              <div className="flex justify-between text-sm font-medium">
                <span>Progress</span>
                <span>{course.progress || 45}%</span>
              </div>
              <Progress value={course.progress || 45} className="h-2" />
            </CardContent>

            <CardFooter>
              <Button className="w-full gap-2" variant="default">
                <PlayCircle className="h-4 w-4" /> Continue Lesson
              </Button>
            </CardFooter>
          </Card>
        ))}
      </div>
    </div>
  );
}