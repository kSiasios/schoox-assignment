import Course from "@/models/course.model";
import { connectToDB } from "@/utils/database";
import { NextResponse } from "next/server";

export const GET = async (
  req: Request,
  { params }: { params: { id: string } }
) => {
  const { id } = params;

  try {
    await connectToDB();

    const course = await Course.findOne({ id: id });

    if (!course) {
      return NextResponse.json(
        {
          error: `Course with ID(${id}) not found!`,
        },
        {
          status: 404,
        }
      );
    }

    return NextResponse.json({ course });
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

export const PUT = async (
  req: Request,
  { params }: { params: { id: string } }
) => {
  const { id } = params;

  return NextResponse.json({ id });
};

export const DELETE = async (
  req: Request,
  { params }: { params: { id: string } }
) => {
  const { id } = params;

  try {
    await connectToDB();

    const course = await Course.findOne({ id: id });

    if (!course) {
      return NextResponse.json(
        {
          error: `Course with ID(${id}) not found!`,
        },
        {
          status: 404,
        }
      );
    }

    const deleted = await Course.deleteOne({ id: id });
    return NextResponse.json({ deleted });
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

  return NextResponse.json({ id });
};
