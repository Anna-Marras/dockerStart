import React from "react";
import { FaReact } from "react-icons/fa";
import "./Card.css";

function Card({ card, onClick, isFlipped, isMatched }) {
  return (
    <div
      className={`card ${isFlipped || isMatched ? "flipped" : ""}`}
      onClick={onClick}
      tabIndex={0}
      aria-label="Carte memory"
      role="button"
      style={{ pointerEvents: isFlipped || isMatched ? "none" : "auto" }}
    >
      <div className="card-inner">
        {/* Dos de la carte : logo React stylisé */}
        <div
          className="card-front"
          style={{
            display: "flex",
            alignItems: "center",
            justifyContent: "center",
            background: "#222831",
          }}
        >
          <FaReact color="#61dafb" size={36} style={{ opacity: 0.3, filter: "blur(0.5px)" }} />
        </div>
        {/* Face de la carte : icône ou image du thème */}
        <div className="card-back">{card.icon}</div>
      </div>
    </div>
  );
}

export default Card;
