import { NextResponse } from "next/server";

export const GET = async (req: Request) => {
  console.log(req);
  return NextResponse.json({ message: "Get Request received" });
};

export const POST = async (req: Request) => {
  console.log(req);
  return NextResponse.json({ message: "Post Request received" });
};
