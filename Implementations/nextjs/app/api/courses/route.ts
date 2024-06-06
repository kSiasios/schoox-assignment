import Course from "@/models/course.model";
import { connectToDB } from "@/utils/database";
import { default as validateData } from "@/utils/helpers";
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

  if (!validateData(data)) {
    return NextResponse.json(
      {
        error: "Invalid Data",
      },
      {
        status: 400,
      }
    );
  }

  let courseData = {
    ...data,
    created_at: `${new Date()}`,
    deleted_at: ` `,
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
