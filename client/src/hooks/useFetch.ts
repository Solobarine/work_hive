import { useState, useCallback } from "react";

type FetchMethod = "GET" | "POST" | "PATCH" | "DELETE";

interface UseFetchOptions extends RequestInit {
  body?: any;
}

interface FetchResponse<T> {
  data: T | null;
  error: string | null;
  loading: boolean;
}

const useFetch = <T>(url: string, method: FetchMethod = "GET") => {
  const [response, setResponse] = useState<FetchResponse<T>>({
    data: null,
    error: null,
    loading: false,
  });

  const fetchData = useCallback(
    async (options: UseFetchOptions = {}) => {
      setResponse({ data: null, error: null, loading: true });

      try {
        const { body, ...restOptions } = options;
        const fetchOptions: RequestInit = {
          method,
          ...restOptions,
        };

        if (body) {
          fetchOptions.body = JSON.stringify(body);
          fetchOptions.headers = {
            ...fetchOptions.headers,
            "Content-Type": "application/json",
          };
        }

        const res = await fetch(url, fetchOptions);
        const data = await res.json();
        console.log(data);

        if (!res.ok) {
          throw new Error(data.message || "Something went wrong");
        }

        setResponse({ data, error: null, loading: false });
      } catch (error: any) {
        setResponse({
          data: null,
          error: error.message || "Something went wrong",
          loading: false,
        });
      }
    },
    [url, method]
  );

  return { ...response, fetchData };
};

export default useFetch;
