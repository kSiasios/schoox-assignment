import Course from "@/models/course.model";
import { connectToDB } from "@/utils/database";
import { NextResponse } from "next/server";

export const GET = async (req: Request) => {
  try {
    await connectToDB();

    const courses = await Course.find({});

    return NextResponse.json({ courses });
  } catch (error) {
    return NextResponse.json(
      {
        error,
      },
      {
        status: 500,
      }
    );
  }
};

export const POST = async (req: Request) => {
  let data = await req.json();

  if (data.status !== "Published" && data.status !== "Pending") {
    return NextResponse.json(
      {
        error: "Status should be 'Published' or 'Pending'",
      },
      {
        status: 500,
      }
    );
  }

  let courseData = {
    id: data.id,
    title: data.title,
    description: data.description,
    status: data.status,
    is_premium: data.is_premium,
    created_at: `${new Date()}`,
    deleted_at: `${new Date()}`,
  };
  try {
    await connectToDB();

    const course = await Course.create(courseData);
    return NextResponse.json(
      { course },
      {
        status: 201,
      }
    );
  } catch (error) {
    return NextResponse.json(
      { error },
      {
        status: 500,
      }
    );
  }
};
