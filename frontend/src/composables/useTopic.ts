export interface TopicResponse {
  message: string
}

export const subscribeToTopic = async (
  token: string,
  topic: string
): Promise<TopicResponse> => {
  const response = await fetch("/api/subscribe-topic.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ token, topic }),
  })
  return await response.json()
}

export const unsubscribeFromTopic = async (
  token: string,
  topic: string
): Promise<TopicResponse> => {
  const response = await fetch("/api/unsubscribe-topic.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ token, topic }),
  })
  return await response.json()
}
