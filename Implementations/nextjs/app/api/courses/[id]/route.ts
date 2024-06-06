import Course from "@/models/course.model";
import { connectToDB } from "@/utils/database";
import validateData from "@/utils/helpers";
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

  let data = await req.json();

  if (!data) {
    return NextResponse.json(
      {
        error: `Missing Data!`,
      },
      {
        status: 400,
      }
    );
  }

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

  await connectToDB();

  const course = await Course.findOne({ id: id });

  if (course.status !== "Deleted" && data.status === "Deleted") {
    data.deleted_at = `${new Date()}`;
  }

  const res = await Course.updateOne({ id: id }, data);

  return NextResponse.json({ res });
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
