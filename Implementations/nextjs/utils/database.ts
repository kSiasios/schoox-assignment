import mongoose from "mongoose";

let isConnected = false;

export const connectToDB = async () => {
  mongoose.set("strictQuery", true);

  if (isConnected) {
    console.log("MongoDB is already connected!");
    return;
  }

  try {
    await mongoose.connect(
      process.env.MONGODB_URI ? process.env.MONGODB_URI : "",
      {
        dbName: "schoox_db",
      }
    );
    isConnected = true;
    console.log("MongoDB connected!");
  } catch (error) {
    console.error(error);
  }
};
