import face_recognition
import os
import sys

def load_known_faces(known_faces_dir):
    known_faces = []
    known_ids = []

    # Ensure absolute path for known_faces_dir
    known_faces_dir = os.path.abspath(known_faces_dir)

    for file_name in os.listdir(known_faces_dir):
        image_path = os.path.join(known_faces_dir, file_name)
        if not image_path.endswith(".jpg"):
            continue
        
        student_id = os.path.splitext(file_name)[0]  # Extract ID from the file name
        known_image = face_recognition.load_image_file(image_path)
        known_encoding = face_recognition.face_encodings(known_image)[0]
        
        known_faces.append(known_encoding)
        known_ids.append(student_id)

    return known_faces, known_ids

def match_face(unknown_image_path, known_faces, known_ids):
    # Ensure absolute path for unknown_image_path
    unknown_image_path = os.path.abspath(unknown_image_path)

    unknown_image = face_recognition.load_image_file(unknown_image_path)
    unknown_encodings = face_recognition.face_encodings(unknown_image)

    if not unknown_encodings:
        return "Unknown"

    for unknown_encoding in unknown_encodings:
        results = face_recognition.compare_faces(known_faces, unknown_encoding)
        if True in results:
            match_index = results.index(True)
            return known_ids[match_index]  # Return matched student ID
    
    return "Unknown"

if __name__ == "__main__":
    known_faces_dir = sys.argv[1]  # Known faces directory
    unknown_image_path = sys.argv[2]  # Uploaded unknown image path
    
    known_faces, known_ids = load_known_faces(known_faces_dir)
    student_id = match_face(unknown_image_path, known_faces, known_ids)
    
    print(student_id)  # Only print the student ID, nothing else
