import React from 'react';
import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from "@components/ui/card";
import { Progress } from "@components/ui/progress";
import { Button } from "@components/ui/button";
import { Badge } from "@components/ui/badge";
import { BookOpen, PlayCircle, Sparkles } from "lucide-react";

export default function DashboardHome({ courses = [] }) {
  return (
    <div className="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
      <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-border pb-6">
        <div>
          <h1 className="text-3xl font-bold tracking-tight text-foreground">My Learning Space</h1>
          <p className="text-sm text-muted-foreground mt-1">Track your active courses, continue lessons, and build your coding skills.</p>
        </div>
        <Button render={<a href="/courses" />} className="gap-2">
          <Sparkles className="h-4 w-4" /> Browse Catalog
        </Button>
      </div>

      {courses && courses.length > 0 ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {courses.map((course) => (
            <Card key={course.id} className="flex flex-col justify-between transition-all hover:shadow-md border-border bg-card">
              <CardHeader className="space-y-2">
                <div className="flex justify-between items-center">
                  <Badge variant="secondary" className="font-semibold text-xs">{course.category || 'Development'}</Badge>
                  <span className="text-xs text-muted-foreground flex items-center gap-1.5 font-medium">
                    <BookOpen className="h-3.5 w-3.5" /> {course.lessons_count || 0} Lessons
                  </span>
                </div>
                <CardTitle className="line-clamp-1 text-lg font-bold">{course.title}</CardTitle>
                <CardDescription className="line-clamp-2 text-xs leading-relaxed">{course.description}</CardDescription>
              </CardHeader>
              
              <CardContent className="space-y-2">
                <div className="flex justify-between text-xs font-medium text-muted-foreground">
                  <span>Completion</span>
                  <span className="text-foreground font-semibold">{course.progress || 0}%</span>
                </div>
                <Progress value={course.progress || 0} className="h-2" />
              </CardContent>

              <CardFooter className="pt-2">
                <Button render={<a href={`/courses/${course.id}`} />} className="w-full gap-2 text-xs" variant="default">
                  <PlayCircle className="h-4 w-4" /> Continue Course
                </Button>
              </CardFooter>
            </Card>
          ))}
        </div>
      ) : (
        <Card className="p-12 text-center border-dashed border-border bg-card/50">
          <div className="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary/10 text-primary mb-4">
            <BookOpen className="h-7 w-7" />
          </div>
          <h3 className="text-lg font-bold text-foreground">No enrolled courses yet</h3>
          <p className="text-sm text-muted-foreground mt-2 max-w-md mx-auto">
            Discover beginner-friendly tutorials, deep-dive architectures, and hands-on coding challenges in our course catalog.
          </p>
          <div className="mt-6">
            <Button render={<a href="/courses" />} className="gap-2">
              Explore Available Courses
            </Button>
          </div>
        </Card>
      )}
    </div>
  );
}